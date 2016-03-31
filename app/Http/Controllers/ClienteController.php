<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cliente as cliente;
use App\Projeto as projeto;
use App\Equipe as equipe;
use App\Models\Access\User\User as user;


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
