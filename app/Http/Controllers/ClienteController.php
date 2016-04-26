<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cliente as cliente;
use App\Projeto as projeto;
use App\Equipe as equipe;
use App\Sprint as sprint;
use App\Historia as historia;
use App\Disciplina as disciplina;
use App\Etapa as etapa;
use App\Models\Access\User\User as user;
use App\Estagio as estag;
use App\Status_Projeto as stp;
use App\Status_tarefa as stt;
use App\Tipo_Tarefa as ttf;
use Kanban;


class ClienteController extends Controller
{

   public function cliente(){
   		return view('backend.modals.clientes.criar');
   }

   public function store(Request $request){
   	$Alldados = $request->all();
   	$dadosBefore = urldecode($Alldados['dados']);
   	$dados = explode('&', $dadosBefore);
   	foreach($dados as $dado){
        $check2 = explode('=',$dado);
        if($check2[1] != ''){
        	$check[$check2[0]] = $check2[1];
        }
    } 
   	$table = $check['tipo_cadastro'];
   	unset($check['tipo_cadastro']);
   	$check['locatario_id'] = access()->user()->locatario_id;
    $check['user_id']   = access()->user()->id;
    switch ($table) {
    	case 'clientes':
    		$new = cliente::create($check);
    		if(isset($new->id)) return '%success&Cliente Cadastrado com Sucesso&C';
    		else return '%error&Erro ao Cadastrar Cliente';
    		break;
    	
      case 'equipes':
        $new = equipe::create($check);
        $resp = user::find($check['responsavel_id']);
        $new->users()->attach($resp);
          if(isset($new->id)) return('%success&Equipe Cadastrada com Sucesso&E&'.$new->id);
          else return('%error&Erro ao Cadastrar Equipe');
        break;

      case 'sprints':
        if(!empty($check['inicio']))
            $check['inicio'] = date_format(date_create_from_format('d/m/Y', $check['inicio']), 'Y-m-d');
       if(!empty($check['termino']))
          $check['termino'] = date_format(date_create_from_format('d/m/Y', $check['termino']), 'Y-m-d');
        $new = sprint::create($check);
          if(isset($new->id)) return('%success&Sprint Cadastrado com Sucesso&S&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Sprint');
        break;

      case 'historias':
          $tipo = $check['tipo'];
          unset($check['tipo']);
          $new = historia::create($check);
          if($tipo == 'sprint'){
            $ide = $new->sprint_id;
          }else{
            $ide = $new->sprint->projeto_id;
          }
          if(isset($new->id)) return('%success&Historia Cadastrada com Sucesso&H&'.$tipo.'&'.$ide);
          else return('%error&Erro ao Cadastrar Historia');
        break;

      case 'disciplinas':
        $new = disciplina::create($check);
          if(isset($new->id)) return('%success&Disciplina Cadastrada com Sucesso&D&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Disciplina');
      break;

     case 'estagios':
        unset($check['user_id']);
        $lastEstag = estag::orderBy('ordem', 'desc')->first();
        $check['ordem'] = (int) $lastEstag->ordem + 1;
        $new = estag::create($check);
          if(isset($new->id)){
            Kanban::configUpdate('Estágios', access()->user()->id, $new->projeto_id);
            return('%success&Estágio Cadastrada com Sucesso&Est&'.$new->projeto_id);
          } 
          else return('%error&Erro ao Cadastrar Estágio');
      break;

      case 'status':
        $new = stp::create($check);
          if(isset($new->id)) return('%success&Status Cadastrado com Sucesso&Stat&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Status');
      break;

      case 'stat_tarefa':
        unset($check['user_id']);
        $new = stt::create($check);
          if(isset($new->id)) return('%success&Status Cadastrado com Sucesso&StaTar&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Status');
      break;

      case 'tipo_tarefa':
      unset($check['user_id']);
      $check['cor']   = '#FFFFFF';
      $check['icone'] = 'default.png';
       $new = ttf::create($check);
          if(isset($new->id)) return('%success&Tipo Cadastrado com Sucesso&TiTa&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Tipo');
      break;

      case 'etapas':
        $new = etapa::create($check);
          if(isset($new->id)) return('%success&Etapa Cadastrada com Sucesso&ET&'.$new->projeto_id);
          else return('%error&Erro ao Cadastrar Etapa');
      break;

    	default:
    		return('%error&Erro ao Armazenar dados');
    		break;
    }
   }

   public function clientesIndex(){
   		return view('backend.clientes');
   }

   public function getClientes(){
   		$clientes = cliente::orderBy('razao')->get();
   		$data = array();
   		foreach($clientes as $cliente){
   			$data[] = array(
   				'razao'		 => '<a href="#" class="cliente-info" id="CID'.$cliente->id.'">'.$cliente->razao.'</a>',
   				'fantasia'   => !empty($cliente->fantasia) ? $cliente->fantasia : '-',
   				'telefone'   => !empty($cliente->fone) ? $cliente->fone : '-',
   				'cidade'     => !empty($cliente->cidade) ? $cliente->cidade : '-',
   				'endereco'   => !empty($cliente->endereco) ? $cliente->endereco : '-'
			);
   		}
   		$total = empty($clientes) ? 0 : $clientes->count();
   		$response['data'] = $data;
   		$response['current'] = 1;
		$response['rowCount'] = 5;
		$response['total'] = $total;

		return $response;
   }

  public function clienteinfo(Request $request){
  	$id = str_replace('CID', '', $request['id']);
  	$cliente = cliente::find($id);
  	return view('backend.modals.clientes.info', compact('cliente'));
  }

   public function clienteEdit(Request $request){
  	$id = str_replace('CDI', '', $request['id']);
  	$cliente = cliente::find($id);
  	return view('backend.modals.clientes.edit', compact('cliente'));
  }

  public function clienteUpdate(Request $request){
  	$Alldados = $request->all();
   	$dadosBefore = urldecode($Alldados['dados']);
   	$dados = explode('&', $dadosBefore);
   	foreach($dados as $dado){
        $check2 = explode('=',$dado);
        if($check2[1] != ''){
        	$check[$check2[0]] = $check2[1];
        }
    } 
    $id = $check['id'];
    unset($check['id']);
    $new = cliente::find($id)->update($check);
		if($new) return '%success&Cliente Atualizado com Sucesso';
		else return '%error&Erro ao Cadastrar Cliente';
  }

  public function clienteDelete(Request $request){
  	$id = str_replace('DCI', '', $request['id']);
  	$cliente = cliente::find($id)->delete();
  	return '%success&Cliente Excluido com Sucesso';
  }

}
