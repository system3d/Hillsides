<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj;
use App\tarefa as task;

class TarefasController extends Controller
{
    public function criar(request $request){
    	$dados = $request->all();
    	$projeto = proj::find($dados['id']);
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
    	return view('backend.modals.tarefas.criar', compact('projeto', 'users', 'dados'));
    }
}
