<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMiscEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

   public $data;
   public $id;


   public function __construct($action, $params , $id)
    {
      $message = array('params'=>$params);
      $this->data = array(
            'message'=>$message,
            'channel'=>'chat-misc-'.$action.'-'.$id
        );
    }

    public function broadcastOn()
    {
         return ['pmessage'];
    }
}
