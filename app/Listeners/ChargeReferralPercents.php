<?php

namespace AffiliateProgram\Listeners;

use AffiliateProgram\Events\UserChargedBalance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use AffiliateProgram\Repositories\UserRepositoryEloquent;
use AffiliateProgram\Models\Payment as Payment;
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
     * @param UserChargedBalance $event
     */
    public function handle(UserChargedBalance $event)
    {
        // check if 1st-level referrer still exists
        if ($referrer = $this->userRepository->getReferrerByReferralId($event->user->id)) {
            $this->addReferralInterest($referrer, $event->user);
            // check if 2st-level referrer still exists
            if ($parentReferrer = $this->userRepository->getReferrerByReferralId($referrer->id)) {
                $this->addReferralInterest($parentReferrer, $referrer);
            }
        }
    }

    /**
     * Add 10% to Referrer of Referral's last charged amount
     *
     * @param User $referrer
     * @param User $referral
     */
    private function addReferralInterest(User $referrer, User $referral)
    {
        $referralLastChargedAmount = $referral->payments()->get()->last() ?: 0;

        if ($referralLastChargedAmount) {
            $referralLastChargedAmount = $referralLastChargedAmount->amount;
        }

        $commission = 0.1 * $referralLastChargedAmount;
        $referrerTotalAmount = $referrer->payments()->get()->last() ?: $commission;

        if ($referrerTotalAmount instanceof Payment) {
            $referrerTotalAmount = (float)$referrerTotalAmount->total_amount + (float)$commission;
        }
        // charge to referrer 10% of referral's last charged amount
        Payment::create([
            'total_amount' => $referrerTotalAmount,
            'amount' => $commission,
            'user_id' => $referrer->id
        ]);
    }


}
