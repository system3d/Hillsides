<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Equipe as equipe;

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

  	return view('backend.modals.equipes.info', compact('equipe'));
  }
}
