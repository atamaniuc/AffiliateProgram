<?php

namespace AffiliateProgram\Listeners;

use AffiliateProgram\Events\UserChargedBalance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChargeReferralPercents
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserChargedBalance  $event
     * @return void
     */
    public function handle(UserChargedBalance $event)
    {
        $chargedAmount = null;
        $referrer = $event->user->referrer($event->user->id);
        
    }
}
