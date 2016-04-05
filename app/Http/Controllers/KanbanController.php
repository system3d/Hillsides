<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;

class KanbanController extends Controller
{
    public function index($id){
    	$projeto = proj::find($id);
    	return view('backend.kanban', compact('projeto'));
    }
}
