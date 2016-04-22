<?php

namespace AffiliateProgram\Listeners;

use AffiliateProgram\Events\UserChargedBalance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use AffiliateProgram\Repositories\UserRepositoryEloquent;
use AffiliateProgram\Models\Payment;
use AffiliateProgram\Models\User;

class ChargeReferralPercents
{
    /**
     * @var UserRepositoryEloquent
     */
    protected $userRepository;

    /**
     * Create the event listener.
     *
     * @param UserRepositoryEloquent $userRepository
     */
    public function __construct(UserRepositoryEloquent $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UserChargedBalance  $event
     * @return void
     */
    public function handle(UserChargedBalance $event)
    {
        // check if referrer still exists
        if ($referrer = $this->userRepository->getReferrerById($event->user->id)) {
            $referrer = User::where('id' , '=' , $referrer->id )->first();
            // check if referral last charged amount exists
            // TODO: $event->user->payments return empty collection, rewrite to repository !
            if ($referralLastChargedAmount = $event->user->payments->last()) {
                $referralLastChargedAmount = $referralLastChargedAmount->amount;
            } else {
                $referralLastChargedAmount = 0.00;
            }

            $commission = 0.1 * $referralLastChargedAmount;

            // check if referrer total amount exists
            if ($referrerTotalAmount = $referrer->payments->last()) {
                $referrerTotalAmount = $referrerTotalAmount->total_amount;
            } else {
                $referrerTotalAmount = $commission;
            }

            // charge to referrer 10% of referral's last charged amount
            // TODO: find a way to check if referrer's last payment didn't changed
            $payment = Payment::create([
                'total_amount' => $referrerTotalAmount,
                'amount' => $commission,
                'user_id' => $referrer->id
            ]);
        }
    }
}
