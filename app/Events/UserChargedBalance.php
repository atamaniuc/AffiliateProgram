<?php

namespace AffiliateProgram\Events;

use AffiliateProgram\Events\Event;
use AffiliateProgram\Models\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use AffiliateProgram\Models\User;

class UserChargedBalance extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var User $user
     */
    public $user;

    /**
     * @var Payment $payment
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->payment = $user->payments()->get()->last();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ["UserChargedBalance_{$this->user->id}"];
    }
}
