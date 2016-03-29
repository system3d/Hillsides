<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Equipe as equipe;
use App\Models\Access\User\User as user;

class EquipesController extends Controller
{
    public function index(){
   		return view('backend.equipes');
   }

    public function getEquipes(){
    	$equipes = equipe::all();
    	$data = array();
   		foreach($equipes as $equipe){
   			$data[] = array(
   				'nome'		 => '<a href="#" class="equipe-info" id="EID'.$equipe->id.'">'.$equipe->descricao.'</a>',
   				'obs'   => !empty($equipe->obs) ? $equipe->obs : '-',
   				'resp'   => !empty($equipe->responsavel_id) ? $equipe->responsavel->name : '-',
   				'memb'  => $equipe->users->count()
			);
   		}
   		$total = empty($equipes) ? 0 : $equipes->count();
   		$response['data'] = $data;
   		$response['current'] = 1;
		$response['rowCount'] = 5;
		$response['total'] = $total;

		return $response;
    }

    public function info(Request $request){
  	$id = str_replace('EID', '', $request['id']);
  	$equipe = equipe::find($id);
    $membros = array();
    foreach($equipe->users as $user):
      $membros[] = $user->id;
    endforeach;
  	return view('backend.modals.equipes.info', compact('equipe', 'membros'));
  }

  public function criar(){
      return view('backend.modals.equipes.criar');
   }

   public function editar(Request $request){
    $id = str_replace('EDI', '', $request['id']);
    $equipe = equipe::find($id);
    return view('backend.modals.equipes.edit', compact('equipe'));
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
    $new = equipe::find($id);
    if($new->responsavel_id != $check['responsavel_id']){
      // $oldResp = user::find($new->responsavel_id);
      // $new->users()->detach($oldResp);
      if(! $new->users->contains($check['responsavel_id'])){
        $newResp = user::find($check['responsavel_id']);
        $new->users()->attach($newResp);
      }
    }
    $new->update($check);
    if($new) return '%success&Equipe Atualizada com Sucesso';
    else return '%error&Erro ao Atualizar Equipe';
  }

  public function delete(Request $request){
    $id = str_replace('DEI', '', $request['id']);
    $equipe = equipe::find($id);
    $equipe->users()->detach();
    $equipe->delete();
    return '%success&Equipe Excluida com Sucesso';
  }

  public function novoMembro(Request $request){
    $id = $request['id'];
    $eid = $request['equipe_id'];
    $equipe = equipe::find($eid);
    $user = user::find($id);
    if(isset($user) && isset($equipe))
      $equipe->users()->attach($user);
    else
      return '%error&Erro ao Atualizar Equipe';

    $response['msg'] = '%success&Equipe Atualizada com Sucesso';
    $response['id'] = 'EID'.$eid;
    return $response;
  }

  public function removerMembro(Request $request){
    $dados = $request->all();
    $id = $dados['id'];
    $eid = $dados['equipe_id'];
    $user = user::find($id);
    $equipe = equipe::find($eid);
    if(isset($user) && isset($equipe))
      $equipe->users()->detach($user);
    else
      return '%error&Erro ao Atualizar Equipe';

    $response['msg'] = '%success&Equipe Atualizada com Sucesso';
    $response['id'] = 'EID'.$eid;
    return $response;
  }
}
