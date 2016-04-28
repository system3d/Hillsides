<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access\User\User as user;

use App\Http\Requests;

class ChatController extends Controller
{
    public function updateStatus(request $request){
    	$dados = $request->all();
    	$users = access()->user()->locatario->users;
    	if($dados['all'] == 'true'){
	    	$statuses = array();
	    	$x = 0;
	    	foreach($users as $user){
	    		if($user->id != access()->user()->id){
		    		$statuses[$x]['user'] = $user->id;
		    		if($user->isOnline()){
		    			$statuses[$x]['html']   = '<i class="fa fa-circle text-success"></i> Online';
		    			$statuses[$x]['status'] = 1;
					}elseif(isset($user->lastActivity->data)){
						$lastActivityObj =  timeDiff($user->lastActivity->data);
						if($lastActivityObj['t'] < 86000){
		                $statuses[$x]['html'] = 'Visto(a) por último à '; 
		                if($lastActivityObj['h'] > 0){
		                	if($lastActivityObj['h'] == 1)
		                  		$statuses[$x]['html'] .= $lastActivityObj['h'].' hora';
		              		else
		              			$statuses[$x]['html'] .= $lastActivityObj['h'].' horas';
		                }else{
		               	  $statuses[$x]['html'] .= $lastActivityObj['m'].' minutos';
		               	}
						$statuses[$x]['status'] = 0;
					}else{
						$statuses[$x]['html']   = '<i class="fa fa-circle text-danger"></i> Offline';
						$statuses[$x]['status'] = 0;
					}
					}else{
						$statuses[$x]['html']   = '<i class="fa fa-circle text-danger"></i> Offline';
						$statuses[$x]['status'] = 0;
					}
		    		$x++;
	    		}
	    	}
	    	return json_encode($statuses);
	    }
    }

    public function window(request $request){
    	$dados = $request->all();
    	$sender = user::find($dados['sender']);
    	$receiver = user::find($dados['receiver']);
    	if(isset($sender) && isset($receiver))
    		return view('backend.includes.partials.message', compact('sender', 'receiver'));
    	else
    		return false;
    }
}
