@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div>
                        <!-- Amount Charger -->
                        <div id="amountCharger" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Charge my Balance</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Select Amount:</h4>
                                        <input name="_token" hidden value="{!! csrf_token() !!}" />
                                        <p><input type="radio" class="amount" name="amount" value="10"> 10 $</p>
                                        <p><input type="radio" class="amount"  name="amount" value="100"> 100 $</p>
                                        <p><input type="radio" class="amount" name="amount" value="500" checked="checked"> 500 $</p>
                                        <p><input type="radio" class="amount" name="amount" value="1000"> 1000 $</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="button" onclick="chargeBalance();" class="btn btn-success">Charge !</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- User Info -->
                        <h4>Name: <code>{{ Auth::user()->name }}</code></h4>
                        <hr>
                        <h4>
                            Balance:
                            <code class="currentAmount" data-amount="{{ $payment->total_amount}}">{{ $payment->total_amount }}</code>
                            <code>$</code>
                            <a role="button" class="btn btn-info" data-toggle="modal" data-target="#amountCharger">Charge</a>
                        </h4>
                        <hr>
                        <h4>
                            <a href="{{ url('/register') }}/?referrer_id={{ Crypt::encrypt( Auth::user()->id) }}">Referral link</a>
                        </h4>
                        <hr>
                        <h4>Referrer: <i>{{ $referrer->name or 'You have no Referrer !' }}</i></h4>
                        <hr>
                        <h4>Referrals:</h4>
                        <ul>
                            @forelse($referrals as $referral)
                                <li><span >{{ $referral->name }}</span></li>
                            @empty
                                <p>You have no Referrals !</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
