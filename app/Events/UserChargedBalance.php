<?php

namespace AffiliateProgram\Events;

use AffiliateProgram\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use AffiliateProgram\Models\User;

class UserChargedBalance extends Event
{
    use SerializesModels;

    /**
     * @var User $user
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
