<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Wallet;

class UsersController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        } else {
            return view('users.login')->withErrors(['errors' => 'Invalid credentials']);
        }
    }

    /**
     * Register user and give one free token.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput($request->except('password'));
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // create a token
        Wallet::create([
            'user_id' => $user->id,
            'token' => bcrypt($input['password'])
        ]);

        return redirect('/login')->with('status', 'User registered successfully.');
    }
}