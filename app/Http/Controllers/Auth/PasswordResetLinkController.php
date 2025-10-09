<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\PasswordResetService;

class PasswordResetLinkController extends Controller
{
    public function __construct(private readonly PasswordResetService $service) {}

    /**
     * Handle sending the password reset email.
     */
    public function store(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Send reset link email
        $this->service->sendResetLink($request->email);

        // Redirect back with a success message
        return back()->with('status', 'Password reset link sent! Check your email.');
    }
}
