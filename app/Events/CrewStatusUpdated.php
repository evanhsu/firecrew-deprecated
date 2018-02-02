<?php

namespace App\Events;

use App\Domain\Statuses\CrewStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

/**
 * Class CrewStatusUpdated
 * @package App\Events
 */
class CrewStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CrewStatus
     */
    public $crewStatus;

    /**
     * Create a new event instance.
     *
     * @param CrewStatus $crewStatus
     */
    public function __construct(CrewStatus $crewStatus)
    {
        $this->crewStatus = $crewStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('publicStatusUpdates');
    }
}
