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
      return view('backend.modals.projetos.info', compact('projeto'));
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
    $statusOld = spd::find($status);
    $statusNewQ = sp::where('descricao', $statusOld->descricao)->where('projeto_id',$new->id)->first();
    $statusNew = array('status_id' => $statusNewQ->id);
    $newU = $new->update($statusNew);
    if(!$newU){
    	$response['msg'] = 'Erro ao atribuir Status ao Projeto';
		$response['status'] = 'error';
		return $response;
    }
   	
   	$stf_def = sfd::all();

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

    foreach($str_def as $fr){
    	$stfrs = array(
    		'descricao'    => $fr->descricao,
    		'icone'        => $fr->icone,
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
			'status'   => $projeto->status->descricao
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
}
