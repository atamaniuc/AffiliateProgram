<?php

namespace AffiliateProgram\Http\Controllers;

use AffiliateProgram\Http\Requests;
use AffiliateProgram\Http\Controllers\Controller;

use AffiliateProgram\Models\User;
use AffiliateProgram\Models\Payment as Payment;
use AffiliateProgram\Repositories\UserRepositoryEloquent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Session;

/**
 * Class UsersController
 * @package AffiliateProgram\Http\Controllers
 */
class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepository->gerUsersWithLatestPayments();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $newUserData = array_merge($request->all(), ['password' => bcrypt('secret')]);
        $selectedAmount = $newUserData['amount'];

        $user = User::create($newUserData);

        Payment::create([
            'total_amount' => $selectedAmount,
            'amount' => $selectedAmount,
            'user_id' => $user->id
        ]);


        Session::flash('flash_message', 'User added!');

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $payment = $user->payments()->get()->last() ?: (object)['total_amount' => '0.00'];

        return view('users.edit', compact('user', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $userData = $request->all();
        $selectedAmount = $userData['amount'];
        $user->update($userData);

        Payment::create([
            'total_amount' => $selectedAmount,
            'amount' => $selectedAmount,
            'user_id' => $user->id
        ]);

        Session::flash('flash_message', 'User updated!');

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('admin/users');
    }

}
