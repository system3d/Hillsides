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
    	return view('backend.kanban', compact('projeto', 'columnWidth'));
    }

    public function historia(request $request){
	$id = $request['id'];
  $obj = proj::find($id);
  $tipo = 'projeto';
  $historias = $obj->historias();

    return view('backend.modals.projetos.historias', compact('obj','tipo','historias'));
    }
}
