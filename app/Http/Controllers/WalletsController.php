<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Wallet;

class WalletsController extends Controller
{
    /**
     * Validate token and consume.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function consume(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/home')->withErrors(['error' => $validator->errors()]);
        }

        $user = Auth::user();
        $token = $request->input('token');
        //validate token
        if (!Hash::check($user->password, $token)) {
            return redirect('/home')->withErrors(['error' => 'Invalid token.']);
        }

        $wallet = $user->active_wallets->where('token', $token)->first();
        if (!$wallet) {
            return redirect('/home')->withErrors(['error' => 'Used token.']);
        }

        $wallet->used = true;
        $wallet->save();

        return redirect('/home')->with('status', 'Token consumed.');
    }

    /**
     * Buy additional token.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function buy(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/home')->withErrors(['error' => $validator->errors()]);
        }

        if ($input['quantity'] <= 0) {
            return redirect('/home')->withErrors(['error' => 'Invalid quantity']);
        }

        $user = Auth::user();
        for ($i = 0; $i < $input['quantity']; $i++) {
            // create a token
            Wallet::create([
                'user_id' => $user->id,
                'token' => bcrypt($user->password)
            ]);
        }

        return redirect('/home')->with('status', $input['quantity'].' token(s) added successfully.');
    }
}