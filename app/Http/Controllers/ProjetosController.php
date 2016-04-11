<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj; 
use App\Tipo_Projeto as tproj;
use App\Estagio_Default as esdef;
use App\Status_Projeto_Default as spd;
use App\Status_Tarefa_Default as sfd;
use App\Tipo_Tarefa_Default as trd;
use App\Estagio as es;
use App\Status_Projeto as sp;
use App\Status_Tarefa as sf;
use App\Tipo_Tarefa as tr;
use App\Equipe as equipe;
use App\Sprint as sprint;
use App\historia as historia;
use App\Disciplina as disc;
use App\Etapa as etapa;

class ProjetosController extends Controller
{
    public function index(){
    	
    	return view('backend.projetos');
    }

     public function criar(){
     	$tipos = tproj::all();
      return view('backend.modals.projetos.criar', compact('tipos'));
   }

   public function info(request $request){
      $projeto = proj::find($request['id']);
      $kanban = true;
      if(isset($request['kanban'])){
        if($request['kanban'] == 'nao'){
          $kanban = false;
        }
      }
      return view('backend.modals.projetos.info', compact('projeto', 'kanban'));
   }

   public function store(request $request){
	$Alldados = $request->all();
   	$dadosBefore = urldecode($Alldados['dados']);
   	$dados = explode('&', $dadosBefore);
   	foreach($dados as $dado){
        $check2 = explode('=',$dado);
        if($check2[1] != ''){
        	$check[$check2[0]] = $check2[1];
        }
    } 
   	$check['locatario_id'] = access()->user()->locatario_id;
    $check['user_id']   = access()->user()->id;
    $status = $check['status_id'];
    unset($check['status_id']);

    $new = proj::create($check);
     if(!isset($new)){
    	$response['msg'] = 'Erro ao Gravar Projeto';
		$response['status'] = 'error';
		return $response;
    }
    $est_def = esdef::all();
    foreach($est_def as $ed){
    	$ests = array(
    		'descricao'    => $ed->descricao,
    		'ordem'        => $ed->ordem,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		$newEs = es::create($ests);
    }

    
    if(!isset($newEs)){
    	$response['msg'] = 'Erro na criação dos Estágios do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $stp_def = spd::all();
    $stps1 = array(
        'descricao'    => 'Ativo',
        'projeto_id'   => $new->id,
        'user_id'      => $check['user_id'],
        'locatario_id' => $check['locatario_id']
    );
    $newSTs1 = sp::create($stps1);
    foreach($stp_def as $pd){
    	$stps = array(
    		'descricao'    => $pd->descricao,
    		'projeto_id'   => $new->id,
    		'user_id'      => $check['user_id'],
    		'locatario_id' => $check['locatario_id']
		);
		$newSTs = sp::create($stps);
    }
    
    if(!isset($newSTs)){
    	$response['msg'] = 'Erro na criação dos Status do Projeto';
		$response['status'] = 'error';
		return $response;
    }
    if($status == '0'){
      $statusNewQ = sp::where('descricao', 'Ativo')->where('projeto_id',$new->id)->first();
    }else{
      $statusOld = spd::find($status);
      $statusNewQ = sp::where('descricao', $statusOld->descricao)->where('projeto_id',$new->id)->first();
    }
    $statusNew = array('status_id' => $statusNewQ->id);
    $newU = $new->update($statusNew);
    if(!$newU){
    	$response['msg'] = 'Erro ao atribuir Status ao Projeto';
		$response['status'] = 'error';
		return $response;
    }
   	
   	$stf_def = sfd::all();
    $stfs2 = array(
        'descricao'    => 'Aberta',
        'projeto_id'   => $new->id,
        'locatario_id' => $check['locatario_id']
    );
     $newSFs2 = sf::create($stfs2);
    foreach($stf_def as $fd){
    	$stfs = array(
    		'descricao'    => $fd->descricao,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		 $newSFs = sf::create($stfs);
    }
   
    if(!isset($newSFs)){
    	$response['msg'] = 'Erro na criação dos Status de Tarefas do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $str_def = trd::all();
    $stfrs2 = array(
        'descricao'    => 'Sem Classificação',
        'icone'        => 'default.png',
        'cor'          => '#fff',
        'projeto_id'   => $new->id,
        'locatario_id' => $check['locatario_id']
    );
    $newSFRs2 = tr::create($stfrs2);
    foreach($str_def as $fr){
    	$stfrs = array(
    		'descricao'    => $fr->descricao,
    		'icone'        => $fr->icone,
        'cor'          => $fr->cor,
    		'projeto_id'   => $new->id,
    		'locatario_id' => $check['locatario_id']
		);
		$newSFRs = tr::create($stfrs);
    }
    
    if(!isset($newSFRs)){
    	$response['msg'] = 'Erro na criação dos Tipos de Tarefas do Projeto';
		$response['status'] = 'error';
		return $response;
    }

    $response['msg'] = 'Projeto Criado com Sucesso';
	$response['status'] = 'success';
	return $response;
	
   }

   public function getProjetos(request $request){
   	$projetos = proj::all();
	$data = array();
	foreach($projetos as $projeto){
		$data[] = array(
			'nome'     => '<a href="#" class="projeto-info" data-id="'.$projeto->id.'">'.$projeto->descricao.'</a>',
			'desc'     => $projeto->obs,
			'cliente'  => $projeto->cliente->razao,
			'status'   => $projeto->status->descricao,
      'criado'   => date('d/m/Y', strtotime($projeto->created_at))
		);
	}
	$total = empty($projetos) ? 0 : $projetos->count();
	$response['data'] = $data;
	$response['current'] = 1;
	$response['rowCount'] = 5;
	$response['total'] = $total;

	return $response;
   }

   public function toggleFavorite(request $request){
   	 $id = $request['id'];
   	 $proj = proj::find($id);
   	 $up = ($proj->favorito == 0) ? 1 : 0;
   	 $toUp = array('favorito' => $up);
   	 $proj->update($toUp);
   	 die('success');
   }

   public function editar(request $request){
   	 $id = $request['id'];
   	 $projeto = proj::find($id);
   	 $tipos = tproj::all();
   	 return view('backend.modals.projetos.editar', compact('projeto', 'tipos'));
   }

   public function update(Request $request){
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
    $new = proj::find($id)->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Projeto';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Projeto Atualizado com Sucesso';
      $response['status'] = 'success';
    }
    
     return $response;
  }

  public function excluir(request $request){
    $iid = $request->all();
    $id = $iid['id'];
    $check = sprint::where('projeto_id',$id)->get();
   if(!empty($check->first()->id)){
      $response['msg'] = 'Projetos com Sprints não podem ser excluídos.';
      $response['status'] = 'error';
      return $response;
    }else{
      $deleted = proj::find($id)->delete();
      if($deleted){
        $response['msg'] = 'Projeto Excluído com Sucesso.';
        $response['status'] = 'success';
      }else{
        $response['msg'] = 'Erro ao excluir projeto.';
        $response['status'] = 'error';
      }
      return $response;
    } 
  }

  public function equipes(request $request){
     $id = $request['id'];
     $projeto = proj::find($id);
     $equipes = equipe::all();
     if($projeto->equipes){
       foreach($equipes as $key => $equipe){
          if($projeto->equipes->contains($equipe)){
            $equipes->forget($key);
          }
       }
     }
     return view('backend.modals.projetos.equipes', compact('projeto', 'equipes'));
   }

   public function novaEquipe(request $request){
    $id = $request['id'];
    $pid = $request['proj_id'];
    $projeto = proj::find($pid);
    $equipe = equipe::find($id);
    if(isset($equipe) && isset($projeto))
      $projeto->equipes()->attach($equipe);
    else{
      $response['msg'] = '%error&Erro ao Adicionar Equipe';
      return $response;
    }
      

    $response['msg'] = '%success&Equipe Adicionada com Sucesso';
    $response['id'] =  $pid;
    return $response;
   }

   public function removerEquipe(Request $request){
    $dados = $request->all();
    $id = $dados['id'];
    $eid = $dados['proj_id'];
    $equipe = equipe::find($id);
    $projeto = proj::find($eid);
    if(isset($projeto) && isset($equipe))
      $projeto->equipes()->detach($equipe);
    else{
       $response['msg'] = '%error&Erro ao Remover Equipe';
       return $response;
     }

    $response['msg'] = '%success&Equipe Atualizada com Sucesso';
    $response['id'] = $eid;
    return $response;
  }

  public function sprints(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
     return view('backend.modals.projetos.sprints', compact('projeto'));
  }

  public function criarSprint(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-sprint', compact('projeto'));
  }

  public function editarSprint(request $request){
    $id = $request['id'];
    $sprint = sprint::find($id);
    return view('backend.modals.projetos.editar-sprint', compact('sprint'));
  }

  public function updateSprint(request $request){
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
    if(!empty($check['inicio']))
        $check['inicio'] = date_format(date_create_from_format('d/m/Y', $check['inicio']), 'Y-m-d');
   if(!empty($check['termino']))
      $check['termino'] = date_format(date_create_from_format('d/m/Y', $check['termino']), 'Y-m-d');
    $sprint = sprint::find($id);
    $new = $sprint->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Sprint';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Projeto Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $sprint->projeto_id;
    }
    
     return $response;
  }

  public function excluirSprint(Request $request){
    $id = $request['id'];
    $new = sprint::find($id);
    $proj_id = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Sprint Excluido com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $proj_id;
    return $response;
  }

  public function historias(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    if($tipo == 'sprint'){
      $obj = sprint::find($id);
      $historias = $obj->historias;
    }
    else{
      $obj = proj::find($id);
      $historias = $obj->historias();
    }
    return view('backend.modals.projetos.historias', compact('obj','tipo','historias'));
  }

  public function criarHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    if($tipo == 'sprint'){
      $obj = sprint::find($id);
      $projeto = $obj->projeto;
    }
    else{
      $obj = proj::find($id);
      $projeto = $obj;
    }
    return view('backend.modals.projetos.criar-historia', compact('obj','tipo','projeto'));
  }

  public function editarHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $historia = historia::find($id);
    $sprints = $historia->sprint->projeto->sprints;
    return view('backend.modals.projetos.editar-historia', compact('historia','tipo','sprints'));
  }

    public function updateHistoria(request $request){
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
     $tipo = $check['tipo'];
    unset($check['tipo']);

    $historia = historia::find($id);
    $idgo = ($tipo == 'sprint') ? $historia->sprint_id : $historia->sprint->projeto_id;
    $new = $historia->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Historia';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Historia Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $idgo;
       $response['tipo'] = $tipo;
    }
    
     return $response;
  }

  public function excluirHistoria(request $request){
    $id = $request['id'];
    $tipo = $request['tipo'];
    $new = historia::find($id);
    $idgo = ($tipo == 'sprint') ? $new->sprint_id : $new->sprint->projeto_id;
    $new->delete();
    $response['msg'] = 'Historia Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    $response['tipo'] = $tipo;
    return $response;
  }

    public function disciplinas(request $request){
    $id = $request['id'];
   $projeto = proj::find($id);
     return view('backend.modals.projetos.disciplinas', compact('projeto'));
  }

    public function criarDisciplinas(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-disciplina', compact('projeto'));
  }

    public function editarDisciplinas(request $request){
    $id = $request['id'];
    $disciplina = disc::find($id);
    return view('backend.modals.projetos.editar-disciplina', compact('disciplina'));
  }

      public function updateDisciplinas(request $request){
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

    $disciplina = disc::find($id);

    $new = $disciplina->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Disciplina';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Disciplina Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $disciplina->projeto_id;
    }
    
     return $response;
  }

   public function excluirDisciplinas(request $request){
    $id = $request['id'];
    $new = disc::find($id);
    $idgo = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Disciplina Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    return $response;
  }


  ///////


  public function etapas(request $request){
    $id = $request['id'];
   $projeto = proj::find($id);
     return view('backend.modals.projetos.etapas', compact('projeto'));
  }

    public function criarEtapas(request $request){
    $id = $request['id'];
    $projeto = proj::find($id);
    return view('backend.modals.projetos.criar-etapa', compact('projeto'));
  }

    public function editarEtapas(request $request){
    $id = $request['id'];
    $etapa = etapa::find($id);
    return view('backend.modals.projetos.editar-etapa', compact('etapa'));
  }

      public function updateEtapas(request $request){
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

    $etapa = etapa::find($id);

    $new = $etapa->update($check);
    if(!isset($new)){
      $response['msg'] = 'Erro ao Atualizar Etapa';
      $response['status'] = 'error';
    }else{
      $response['msg'] = 'Etapa Atualizado com Sucesso';
      $response['status'] = 'success';
       $response['id'] = $etapa->projeto_id;
    }
    
     return $response;
  }

   public function excluirEtapas(request $request){
    $id = $request['id'];
    $new = etapa::find($id);
    $idgo = $new->projeto_id;
    $new->delete();
    $response['msg'] = 'Etapa Excluida com Sucesso';
    $response['status'] = 'success';
    $response['id'] = $idgo;
    return $response;
  }


  ////





}
