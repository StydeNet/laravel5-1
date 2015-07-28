<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function getPassword()
    {
        return view('account/password');
    }

    public function postPassword(Request $request)
    {
        $user = $request->user();

        if(!Hash::check($request->get('current_password'), $user->password))
        {
            return redirect()->back()->withErrors([
               'current_password' => 'The current password is not valid'
            ]);
        }

        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect('account')
            ->with('alert', 'Your password has been changed');
    }

}
