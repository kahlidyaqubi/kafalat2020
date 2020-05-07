<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class NewLogCreated
 * @package App\Events
 */
class NewLogCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $message, $name, $log_category_id, $path_status, $path;

    /**
     * NewLogCreated constructor.
     * @param $message
     * @param $name
     * @param $log_category_id
     * @param $path_status
     * @param $path
     */
    public function __construct($message, $name, $log_category_id, $path_status, $path)
    {
        $this->message = $message;
        $this->name = $name;
        $this->log_category_id = $log_category_id;
        $this->path_status = $path_status;
        $this->path = $path;
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
