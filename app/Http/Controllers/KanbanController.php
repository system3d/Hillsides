<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;
use App\Setting as set;
use App\Equipe as equipe;
use App\Historia as hist;
use Cache;
use Kanban;
use JavaScript;

class KanbanController extends Controller
{
    public function index($id){
    	$projeto = proj::find($id);
    	$estCount = $projeto->estagios->count();
		$columnWidth = 92 / ($estCount + 2);
		$columnWidth = $columnWidth.'%';
    $users = array();
    $usersIn = array();
    foreach($projeto->equipes as $equipe){
        foreach($equipe->users as $membro){
          if(!in_array($membro->id, $usersIn)){
            $users[] = $membro;
            $usersIn[] = $membro->id;
          }
        }
      }
      $users = collect($users);
      if (Cache::has('history-'.access()->user()->id)) {
        $dados = Cache::pull('history-'.access()->user()->id);
      }else{
        $dados = array(
          "sprint" => "0",
          "story" => "0",
          "user" => "0",
          "dis" => "0",
          "etapa" => "0",
          "equipe" => "0"
        );
      }
      JavaScript::put(['thisProjetoId'=>$projeto->id]);
      
           $last = set::where('model', 'kanban')->where('name','return')->where('user_id',access()->user()->id)->first();
    if(!isset($last->param)){
      set::create(['model' => 'kanban', 'name' => 'return', 'param' => $id, 'user_id' => access()->user()->id, 'locatario_id' => access()->user()->locatario_id]);
    }else{
      $last->update(['param' => $id]);
    }
    	return view('backend.kanban', compact('projeto', 'columnWidth','users', 'dados'));
    }

  public function historia(request $request){
  	$id = $request['id'];
    $obj = proj::find($id);
    $tipo = 'projeto';
    $historias = $obj->historias();

    return view('backend.modals.projetos.historias', compact('obj','tipo','historias'));
  }

  public function setHistory(request $request){
    $dados = $request->all();
    $projeto = $dados['projeto'];
    unset($dados['projeto']);
    Cache::put('history-'.access()->user()->id, $dados,5);
    return route('kanban',[$projeto]);
  }

  public function return(request $request){
    $last = set::where('model', 'kanban')->where('name','return')->where('user_id',access()->user()->id)->first();
    if(!isset($last->param)){
      return url('projetos');
    }else{
      return url('kanban/'.$last->param);
    }
  }

  public function histchanged(request $request){
    $history = hist::find($request['id']);
    $r = [];
    if(isset($history->id)){
      $es = [];
      foreach($history->tarefas as $t){
        if(isset($t->assignee->id)){
          foreach($t->assignee->equipes as $e){
            if(!in_array($e->id, $es)){
              $es[] = $e->id;
            }
          }
        }
      }
      if(count($es) > 0){
        $r['status'] = 'success';
        $r['equipes'] = $es;
      }else{
         $r['status'] = 'error';
      }
    }else{
      $r['status'] = 'error';
    }
    return $r;
  }

  public function equipchanged(request $request){
    $idtemp = $request['ids'];
    $ids = [];
    if(!is_array($idtemp)){
      $ids[] = $idtemp;
    }else{
      $ids = $idtemp;
    }
    $us = [];
    foreach($ids as $id){
      $e = equipe::find($id);
      if(isset($e->id)){
        foreach($e->users as $u){
          if(!in_array($u->id, $us)){
            $us[] = $u->id;
          }
        }
      }
    }
    return $us;
  }

  public function teste(){
    kanban::taskUpdate(4,79,80,2);
  }

}

// 294219580
// x4x7i6