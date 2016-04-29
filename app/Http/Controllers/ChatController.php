<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access\User\User as user;
use App\Mensagem as msg;
use Event;
use App\Events\MessageSend;

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
    	$sid = $sender->id;
    	$riv = $receiver->id;
    	$messages = msg::where(function ($query) use($sid,$riv){
	    $query->where('sender_id', $sid)
	        ->where('receiver_id', $riv);
	})->orWhere(function($query) use($sid,$riv){
	    $query->where('receiver_id', $sid)
	        ->where('sender_id', $riv);
	    })->orderBy('created_at')->get();
    	if(isset($sender) && isset($receiver))
    		return view('backend.includes.partials.message', compact('sender', 'receiver','messages'));
    	else
    		return false;
    }

   public function send(request $request){
   	 $dados = $request->all();
   	 if(!empty($dados['msg']) && !empty($dados['receiver'])){
   	 	$new = msg::create(['message' => $dados['msg'], 'sender_id' => access()->user()->id, 'receiver_id' => $dados['receiver'], 'status' => 0, 'locatario_id' => access()->user()->locatario_id]);
   	 }
   	 if(isset($new->id)){
   	 	$response['status'] = $new->status;
   	 	$response['msg'] = $new->message;
   	 	$response['id'] = $new->id;
   	 	$response['name'] = $new->sender->name;
   	 	$response['receiver'] = $new->receiver_id;
   	 	$response['sender'] = $new->sender_id;
   	 	$response['time'] = datePtFormat($new->created_at);
   	 	$header['name'] = $new->sender->name;
   	 	$header['date'] = datePtFormat($new->created_at);
   	 	$header['status'] = $new->status;
   	 	$header['id'] = $new->id;
   	 	Event::fire(new MessageSend($new->message,$new->sender_id,$new->receiver_id,$header));
   	 }else{
   	 	$response['status'] = 3;
   	 	$response['msg'] = $dados['msg'];
   	 	$response['receiver'] = $dados['receiver'];
   	 	$response['sender'] = access()->user()->id;
   	 	$response['time'] = datePtFormat(date('Y-m-d H:i:s'));
   	 }
   	return $response;
   }
}
