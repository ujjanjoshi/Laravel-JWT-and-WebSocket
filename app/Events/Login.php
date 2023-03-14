<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Login implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id;
    public $token;
    public $notifynumber;
    public function __construct($token,$id,$notifynumber)
    {
        $this->token=$token;
        $this->id=$id;
        $this->notifynumber=$notifynumber;
    }

    public function broadcastOn()
    {
        return [
            new Channel('public.login.1'),
        ];
    }
    public function broadcastAs()
    {
        return 'login';
    }

    public function broadcastWith(){
        return ["token"=>$this->token,"id"=>$this->id,"notificationss"=>$this->notifynumber];
    }

}
