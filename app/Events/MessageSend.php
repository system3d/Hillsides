<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSend extends Event implements ShouldBroadcast
{
    use SerializesModels;

   public $data;
   public $id;


   public function __construct($msg, $sender , $receiver, $header)
    {
      $message = array('message'=>$msg, 'sender'=>$sender, 'receiver' => $receiver, 'header' => $header);
      $this->data = array(
            'message'=>$message,
            'channel'=>'message-'.$receiver
        );
    }

    public function broadcastOn()
    {
         return ['pmessage'];
    }
}
