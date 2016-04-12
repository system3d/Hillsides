<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class KanbanEvent extends Event
{
  use SerializesModels;

    public $data;
    public $id;


   public function __construct($content, $style , $title,  $id)
    {
      $message = array('title'=>$title, 'message'=>$content,'type'=>$style);
      $this->id = $id;
      $this->data = array(
            'message'=>$message,
            'channel'=>'kanban-'.$this->id
        );
    }

    public function broadcastOn()
    {
         return ['pmessage'];
    }

}
