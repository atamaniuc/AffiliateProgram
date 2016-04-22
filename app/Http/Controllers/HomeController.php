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

/**
 * Class HomeController
 * @package AffiliateProgram\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $referrer = $user->referrer($user->id);
        $referrals = $user->referrals($user->id);

       /* $referrerSql = $referrer->getBaseQuery()->toSql();
        $referralsSql = $referrals->getBaseQuery()->toSql();
        
        $referrerResults = $referrer->getResults();
        $referralsResults = $referrals->getResults();*/

       // $referrals->simplePaginate(6);
        
        return view('home')->with(compact('referrer', 'referrals'));
    }

    /**
     * Charge User Amount
     */
    public function chargeUserAmount()
    {
        $response = ['status' => false];

        if ($user = Auth::user()) {
            $currentAmount = $user->amount;
            $selectedAmount = Input::get('amount');
            
            $user->setAttribute('amount', $currentAmount + $selectedAmount);
            $user->save();

            // Trigger UserChargedBalance-Event to update referral percents for Referrer (parent) User
            Event::fire(new UserChargedBalance($user));

            $response = ['status' => true];
        }

        echo json_encode($response);
    }

}
