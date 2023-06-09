<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OverallNotice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create a new event instance.
     */
    public $message;
    public function __construct($message)
    {
        $this->message=$message;
    }
    public function broadcastOn()
    {
        return new Channel('public.overallnotice.1');
    }
    public function broadcastAs()
    {
        return 'overallnotice';
    }

    public function broadcastWith(){
        return ["message"=>"New Notification !!","detailedmessage"=>$this->message];
    }


}
