<?php

namespace AffiliateProgram\Http\Controllers;

use Event;
use AffiliateProgram\Events\UserChargedBalance;
use AffiliateProgram\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use URL;
use AffiliateProgram\Models\User;
use AffiliateProgram\Models\Payment;
use AffiliateProgram\Repositories\UserRepositoryEloquent;

/**
 * Class UserController
 * @package AffiliateProgram\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryEloquent
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepositoryEloquent $userRepository
     */
    public function __construct(UserRepositoryEloquent $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    /**
     * Render User profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function renderProfile()
    {
        $user = Auth::user();

        $referrer = $this->userRepository->getReferrerByReferralId($user->id);
        $referrals = $this->userRepository->gerReferralsByReferrerId($user->id);

        $payment = $user->payments()->get()->last() ?: (object)['total_amount' => '0.00'];

        return view('profile')->with(compact('referrer', 'referrals', 'payment'));
    }

    /**
     * Charge User Amount.
     */
    public function chargeAmount()
    {
        $response = ['status' => false];

        if ($user = Auth::user()) {
            $currentAmount = $user->payments()->get()->last() ?: 0;
            
            if ($currentAmount) {
                $currentAmount = $currentAmount->total_amount;
            }

            $selectedAmount = Input::get('amount');
            $payment = Payment::create([
                'total_amount' => (float)$currentAmount + (float)$selectedAmount,
                'amount' => $selectedAmount,
                'user_id' => $user->id
            ]);

            // update commission for referrers
            Event::fire(new UserChargedBalance($user));

            setlocale(LC_MONETARY, 'en_US');
            $response = ['status' => true, 'total_amount' => money_format('%i', $payment->total_amount)];
        }

        return response()->json($response);
    }

    /**
     * Get Total Amount. Need for Long Polling Fallback.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalAmount()
    {
        $response = ['status' => false];

        if ($user = Auth::user()) {
            $payment = $user->payments()->get()->last() ?: 0;
            setlocale(LC_MONETARY, 'en_US');
            $response = ['status' => true, 'total_amount' => money_format('%i', $payment ? $payment->total_amount : 0)];
        }
        return response()->json($response);
    }

}
