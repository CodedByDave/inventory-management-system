<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function __construct(private readonly PasswordResetService $service) {}

    /**
     * Show reset password form
     */
    public function create(Request $request)
    {
        return view('auth.reset', [
            'token' => $request->query('token'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Handle resetting the user's password
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Use only the necessary fields
        $data = $request->only(['email','token','password','password_confirmation']);

        $status = $this->service->resetPassword($data);

        if ($status === Password::PASSWORD_RESET) {
            // Use session flash for SweetAlert
            return redirect()->route('login')->with('success', 'Password reset successfully.');
        }

        return back()->with('error', 'Failed to reset password. Please try again.');
    }
}
