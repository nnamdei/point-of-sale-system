<?php

namespace App\Events;

use App\Staff;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StaffAuthorization
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $staff; 
    public $position; 
    public $password;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Staff $staff, $position, $password)
    {
        $this->staff = $staff;
        $this->position = $position;
        $this->password = $password;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
