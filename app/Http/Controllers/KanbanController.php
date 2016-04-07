<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;

class KanbanController extends Controller
{
    public function index($id){
    	$projeto = proj::find($id);
    	$estCount = $projeto->estagios->count();
		$columnWidth = 95 / ($estCount + 2);
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
    	return view('backend.kanban', compact('projeto', 'columnWidth','users'));
    }

    public function historia(request $request){
	$id = $request['id'];
  $obj = proj::find($id);
  $tipo = 'projeto';
  $historias = $obj->historias();

    return view('backend.modals.projetos.historias', compact('obj','tipo','historias'));
    }
}
