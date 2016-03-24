<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TesteEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
    //public $id;


   public function __construct($message)
    {
      //$message = array('title'=>$title, 'message'=>$content,'type'=>$style);
      //$this->id = $id;
      $this->data = array(
            'message'=>$message,
            'channel'=>'teste'
        );
    }

    public function broadcastOn()
    {
         return ['pmessage'];
    }

}
