<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Models\User;

class PasswordResetService
{
    /**
     * Reset password using Laravel's Password broker
     */
    public function resetPassword(array $data)
    {
        return Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    }

    /**
     * Send reset link email
     */
    public function sendResetLink(string $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $token = Password::createToken($user);

        Mail::to($email)->send(new ForgotPassword($token, $email));
    }
}
