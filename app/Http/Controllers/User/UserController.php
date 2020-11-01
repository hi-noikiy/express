<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Create;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('email', '!=', 'admin@gmail.com')->get();

        return view('user.index')->with('users', $users);
    }

    public function createView()
    {
        return view('user.create');
    }

    public function create(Create $request)
    {
        $input = $request->all();
        $userCreate = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => encrypt($input['password']),
        ];
        User::create($userCreate);

        return redirect()->route('user');
    }

    public function enable($id)
    {
        $user = User::find($id);
        $user->status = $user->status ? 0 : 1;
        $user->save();

        return redirect()->route('user');
    }

    public function delete($id)
    {
        User::destroy($id);

        return redirect()->route('user');
    }
}
