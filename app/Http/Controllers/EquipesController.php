<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Equipe as equipe;
use App\Models\Access\User\User as user;

class EquipesController extends Controller
{
    public function index(){
      if(!isAllowed('ver-equipes') && !isAllowed('ver-equipes-self')){
         \Session::flash('flash_danger', 'Você não tem permissão para fazer isto.');
         return redirect()->back();
      } 
   		return view('backend.equipes');
   }

    public function getEquipes(){
    	$equipes = equipe::all();
    	$data = array();
      if(access()->user()->hasRole(1)){
        foreach($equipes as $equipe){
          $data[] = array(
            'nome'     => '<a href="#" class="equipe-info" id="EID'.$equipe->id.'">'.$equipe->descricao.'</a>',
            'obs'   => !empty($equipe->obs) ? $equipe->obs : '-',
            'resp'   => !empty($equipe->responsavel_id) ? $equipe->responsavel->name : '-',
            'memb'  => $equipe->users->count()
        );
        }
      }else{
        foreach($equipes as $equipe){
          if($equipe->responsavel->id === access()->user()->id){
            $data[] = array(
              'nome'     => '<a href="#" class="equipe-info" id="EID'.$equipe->id.'">'.$equipe->descricao.'</a>',
              'obs'   => !empty($equipe->obs) ? $equipe->obs : '-',
              'resp'   => !empty($equipe->responsavel_id) ? $equipe->responsavel->name : '-',
              'memb'  => $equipe->users->count()
            );
          }
        }
      }

   		$total = empty($equipes) ? 0 : $equipes->count();
   		$response['data'] = $data;
   		$response['current'] = 1;
		$response['rowCount'] = 5;
		$response['total'] = $total;

		return $response;
    }

    public function info(Request $request){
      if(!isAllowed('ver-equipes') && !isAllowed('ver-equipes-self')){
        return view('backend.modals.unauthorized');
      } 
  	$id = str_replace('EID', '', $request['id']);
  	$equipe = equipe::find($id);
    $membros = array();
    foreach($equipe->users as $user):
      $membros[] = $user->id;
    endforeach;
  	return view('backend.modals.equipes.info', compact('equipe', 'membros'));
  }

  public function infoSmall(Request $request){
    if(!isAllowed('ver-equipes') && !isAllowed('ver-equipes-self')){
      return view('backend.modals.unauthorized');
    }
    $id = str_replace('EID', '', $request['id']);
    $equipe = equipe::find($id);

    return view('backend.modals.equipes.info-small', compact('equipe'));
  }

  public function criar(){
    if(!isAllowed('criar-equipes')){
      return view('backend.modals.unauthorized');
    }
      return view('backend.modals.equipes.criar');
   }

   public function editar(Request $request){
    if(!isAllowed('criar-equipes')){
      return view('backend.modals.unauthorized');
    }
    $id = str_replace('EDI', '', $request['id']);
    $equipe = equipe::find($id);
    return view('backend.modals.equipes.edit', compact('equipe'));
  }

  public function update(Request $request){
    if(!isAllowed('criar-equipes')){
      return '%error&Você não tem permissão para fazer isto.';
    }
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
    $oldResp = $new->responsavel;
    $userRole = user::find($check['responsavel_id']); 
    
    if($new->responsavel_id != $check['responsavel_id']){
      // $oldResp = user::find($new->responsavel_id);
      // $new->users()->detach($oldResp);
      if(! $new->users->contains($check['responsavel_id'])){
        $newResp = user::find($check['responsavel_id']);
        $new->users()->attach($newResp);
      }
    }
    $new->update($check);
    $userRole->handleLider();
    $oldResp->handleLider();
    if($new) return '%success&Equipe Atualizada com Sucesso';
    else return '%error&Erro ao Atualizar Equipe';
  }

  public function delete(Request $request){
    if(!isAllowed('deletar-equipes')){
      return '%error&Você não tem permissão para fazer isto.';
    }
    $id = str_replace('DEI', '', $request['id']);
    $equipe = equipe::find($id);
    $userRole = $equipe->responsavel;
    $userRole->handleLider();
    $equipe->users()->detach();
    $equipe->delete();
    return '%success&Equipe Excluida com Sucesso';
  }

  public function novoMembro(Request $request){
    if(!isAllowed('criar-equipes') && !isAllowed('add-equipe-self')){
      return '%error&Você não tem permissão para fazer isto.';
    }
    $id = $request['id'];
    $eid = $request['equipe_id'];
    $equipe = equipe::find($eid);
    $user = user::find($id);
    if(isset($user) && isset($equipe))
      $equipe->users()->attach($user);
    else{
      $response['msg'] = '%error&Erro ao Atualizar Equipe';
      return $response;
    }

    $response['msg'] = '%success&Equipe Atualizada com Sucesso';
    $response['id'] = 'EID'.$eid;
    return $response;
  }

  public function removerMembro(Request $request){
    if(!isAllowed('criar-equipes') && !isAllowed('add-equipe-self')){
      return '%error&Você não tem permissão para fazer isto.';
    }
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
