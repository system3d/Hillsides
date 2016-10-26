<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access\User\User as user;
use App\Mensagem as msg;
use App\Setting as set;
use Event;
use App\Events\MessageSend;
use App\Events\ChatMiscEvent;
use Carbon\Carbon;
use DB;

use App\Http\Requests;

class ChatController extends Controller
{
    public function index(){
      $messages = getLastMessages();
      return view('backend.messages.index', compact('messages'));
    }

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
      $uid = access()->user()->id;
      $reset = set::where('user_id',$uid)->where('model','chat')->where('name','reset')->first();
      $sender = user::find($dados['sender']);
      $receiver = user::find($dados['receiver']);
      $sid = $sender->id;
      $riv = $receiver->id;
      if(isset($reset->param)){
         $rp = Carbon::now();
         $td = explode(' ',$reset->param);
         $d = explode('-',$td[0]);
         $t = explode(':',$td[1]);
         $rp->year($d[0])->month($d[1])->day($d[2])->hour($t[0])->minute($t[1])->second($t[2]);
         $messages = msg::where('created_at', '>=', $rp)->where(function ($query) use($sid,$riv){
            $query->where('sender_id', $sid)
                ->where('receiver_id', $riv);
        })->orWhere(function($query) use($sid,$riv){
            $query->where('receiver_id', $sid)
                ->where('sender_id', $riv);
            })->where('created_at', '>=', $rp)->orderBy('created_at')->take(40)->get();
      }else{
        $messages = msg::where(function ($query) use($sid,$riv){
            $query->where('sender_id', $sid)
                ->where('receiver_id', $riv);
        })->orWhere(function($query) use($sid,$riv){
            $query->where('receiver_id', $sid)
                ->where('sender_id', $riv);
            })->orderBy('created_at')->take(40)->get();
      }

    	if(isset($sender) && isset($receiver))
    		return view('backend.includes.partials.message', compact('sender', 'receiver','messages'));
    	else
    		return false;
    }

   public function send(request $request){
   	 $dados = $request->all();
   	 if(!empty($dados['msg']) && !empty($dados['receiver'])){
   	 	$msg = htmlentities($dados['msg']);
   	 	$new = msg::create(['message' => $msg, 'sender_id' => access()->user()->id, 'receiver_id' => $dados['receiver'], 'status' => 0, 'locatario_id' => access()->user()->locatario_id]);
   	 }
   	 if(isset($new->id)){
   	 	$response['status'] = $new->status;
   	 	$response['msg'] = $new->message;
   	 	$response['id'] = $new->id;
   	 	$response['name'] = $new->sender->name;
   	 	$response['receiver'] = $new->receiver_id;
   	 	$response['sender'] = $new->sender_id;
   	 	$response['time'] = datePtFormat($new->created_at);
   	 	$header['name'] = str_limit($new->sender->name,25);
   	 	$header['date'] = datePtFormat($new->created_at);
      $header['created_at'] = $new->created_at;
   	 	$header['status'] = 'R';
      $header['avatar'] = $new->sender->avatar;
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

   public function read(request $request){
    $dados = $request->all();
    $id = $dados['id'];
    $update = msg::where('sender_id',$id)->where('receiver_id',access()->user()->id)->where('status',0)->update(['status'=>1]);
    if($update > 0){
      $response = ['do' => 1];
      Event::fire(new ChatMiscEvent('read',access()->user()->id, $id));
    }else{
     $response = ['do' => 0];
    }
     return $response;
  }

  public function getUsers(request $request){
    $users = access()->user()->locatario->users->sortBy('name');
    // $users = $users->keyBy('id');
    // $users->forget(access()->user()->id);
    $sid = access()->user()->id;
    foreach($users as $user){
      if($user->id != $sid){
          $riv = $user->id;
          $messages = msg::select('created_at')->where(function ($query) use($sid,$riv){
            $query->where('sender_id', $sid)
                ->where('receiver_id', $riv);
          })->orWhere(function($query) use($sid,$riv){
            $query->where('receiver_id', $sid)
                ->where('sender_id', $riv);
            })->orderBy('created_at','desc')->first();
          if(isset($messages->created_at))
            $user->last = $messages->created_at;
            $unreads = msg::select('id')->where('sender_id',$riv)->where('receiver_id',$sid)->where('status',0)->get();
            $user->unreads = $unreads->count();
        }
      }
    return json_encode($users);
  }

  public function getMessages(request $request){
    $dados = $request->all();
    $riv = $dados['id'];
    $sid = access()->user()->id;
    $reset = set::where('user_id',$sid)->where('model','chat')->where('name','reset')->first();
    if(isset($reset->param)){
       $rp = Carbon::now();
       $td = explode(' ',$reset->param);
       $d = explode('-',$td[0]);
       $t = explode(':',$td[1]);
       $rp->year($d[0])->month($d[1])->day($d[2])->hour($t[0])->minute($t[1])->second($t[2]);
       $msgs = msg::where('created_at', '>=', $rp)->where(function ($query) use($sid,$riv){
        $query->where('sender_id', $sid)
            ->where('receiver_id', $riv);
      })->orWhere(function($query) use($sid,$riv){
        $query->where('receiver_id', $sid)
            ->where('sender_id', $riv);
        })->where('created_at', '>=', $rp)->orderBy('created_at','desc')->skip($dados['skip'])->take($dados['take'])->get();
    }else{
      $msgs = msg::where(function ($query) use($sid,$riv){
        $query->where('sender_id', $sid)
            ->where('receiver_id', $riv);
      })->orWhere(function($query) use($sid,$riv){
        $query->where('receiver_id', $sid)
            ->where('sender_id', $riv);
        })->orderBy('created_at','desc')->skip($dados['skip'])->take($dados['take'])->get();
    }
    foreach($msgs as $msg){
      $msg->day = $this->setDay($msg->created_at);
    }

    if($msgs->count() < 20){
      $response['done'] = true;
    }else{
      $response['done'] = false;
    }
    $response['msgs'] = $msgs;
    return json_encode($response);
  }

  public function reset(request $request){
    $uid = access()->user()->id;
    $last = set::where('user_id',$uid)->where('model','chat')->where('name','reset')->first();
    if(!isset($last->id)){
      $created = set::create(['model' => 'chat', 'name' => 'reset', 'param' => date('Y-m-d H:i:s'), 'user_id' => $uid, 'locatario_id' => access()->user()->locatario_id]);
    }else{
      $created = $last->update(['param' => date('Y-m-d H:i:s')]);
    }
    $r = [];
    if($created){
      $r['status'] = 'success';
      $r['msg'] = 'Histórico deletado com sucesso.';
      Event::fire(new ChatMiscEvent('reset',access()->user()->id, access()->user()->id));
    }
    else{
      $r['status'] = 'error';
      $r['msg'] = 'Erro ao deletar Histórico.';
    }
    return $r;
  }

  private function setDay($val){
    return date('Y-m-d',strtotime($val));
  }
}
