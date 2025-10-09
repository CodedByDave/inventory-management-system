<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginService
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Determine redirect URL based on role
            $redirectUrl = $this->getDashboardUrl($user->role);

            if (!$redirectUrl) {
                Auth::logout();
                return redirect()->route('login')->with([
                    'alert_type' => 'error',
                    'alert_message' => 'Unauthorized: No dashboard assigned for your role.'
                ]);
            }

            // Return with success message and redirect URL
            return redirect()->route('login')->with([
                'alert_type' => 'success',
                'alert_message' => 'Login successful! Redirecting to dashboard...',
                'redirect_url' => $redirectUrl
            ]);
        }

        return back()->with([
            'alert_type' => 'error',
            'alert_message' => 'Invalid credentials.'
        ]);
    }

    private function getDashboardUrl($role)
    {
        switch ($role) {
            case 'admin':
                return route('filament.admin.pages.dashboard');
            case 'manager':
                return route('filament.manager.pages.dashboard');
            case 'staff':
                return route('filament.staff.pages.dashboard');
            case 'finance':
                return route('filament.finance.pages.dashboard');
            default:
                return null;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with([
            'alert_type' => 'success',
            'alert_message' => 'You have been logged out successfully.'
        ]);
    }
}
