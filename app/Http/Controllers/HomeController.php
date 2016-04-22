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
 * Class HomeController
 * @package AffiliateProgram\Http\Controllers
 */
class HomeController extends Controller
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
    public function index()
    {
        $user = Auth::user();

        $referrer = $this->userRepository->getReferrerById($user->id);
        $referrals = $this->userRepository->gerReferralsById($user->id);

        $payment = $user->payments->last() ?: (object) ['total_amount' => '0.00'];

        return view('home')->with(compact('referrer', 'referrals', 'payment'));
    }

    /**
     * Charge User Amount
     */
    public function chargeUserAmount()
    {
        $response = ['status' => false];

        if ($user = Auth::user()) {
            if ($currentAmount = $user->payments->last()) {
                $currentAmount = $currentAmount->total_amount;
            } else {
                $currentAmount = 0.00;
            }

            $selectedAmount = Input::get('amount');
            
            $payment = Payment::create([
                'total_amount' => $currentAmount + $selectedAmount,
                'amount' => $selectedAmount,
                'user_id' => $user->id
            ]);

            // Trigger UserChargedBalance-Event to update referral percents for Referrer (parent) User
            Event::fire(new UserChargedBalance($user));

            $response = ['status' => true, 'total_amount' => $payment->total_amount];
        }

        return response()->json($response);
    }

}
