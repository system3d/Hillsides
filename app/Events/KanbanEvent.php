<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class KanbanEvent extends Event implements ShouldBroadcast
{
  use SerializesModels;

    public $data;
    public $id;


   public function __construct($action,$task, $est , $notify, $user, $id)
    {
      $message = array('task'=>$task, 'est'=>$est, 'notify' => $notify, 'user'=>$user,'action'=>$action);
      $this->data = array(
            'message'=>$message,
            'channel'=>'kanban-'.$id
        );
    }

    public function broadcastOn()
    {
         return ['pmessage'];
    }

}
