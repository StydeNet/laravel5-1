<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{

    public function getPassword()
    {
        return view('account/password');
    }

    public function postPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $credentials = $request->only(
            'current_password', 'password', 'password_confirmation'
        );

        $response = $this->validateCredentials($request->user(), $credentials, function ($user, $password) {
            $this->changePassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect('account')
                    ->with('alert', 'Your password has been changed');

            default:
                return redirect()->back()->withErrors([
                    ['current_password' => trans($response)]
                ]);
        }
    }

    public function editProfile(Request $request)
    {
        return view('account/edit-profile', [
            'user' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required|min:2'
        ]);

        $user->fill($request->only(['name']));
        $user->save();

        return redirect('account')
            ->with('alert', 'Your profile has been updated');
    }

    /**
     * @param User $user
     * @param $password
     */
    private function changePassword(User $user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
    }

    /**
     * @param User $user
     * @param $credentials
     * @param $callback
     * @return string
     */
    private function validateCredentials(User $user, $credentials, $callback)
    {
        list($password, $newPassword, $confirm) = [
            $credentials['current_password'],
            $credentials['password'],
            $credentials['password_confirmation'],
        ];

        if (! Hash::check($password, $user->password)) {
            return Password::INVALID_USER;
        }

        if (! $this->validateNewPassword($newPassword, $confirm)) {
            return Password::INVALID_PASSWORD;
        }

        call_user_func($callback, $user, $newPassword);

        return Password::PASSWORD_RESET;
    }

    /**
     * @param $password
     * @param $confirm
     * @return bool
     */
    private function validateNewPassword($password, $confirm)
    {
        return $password === $confirm && mb_strlen($password) >= 6;
    }
}

