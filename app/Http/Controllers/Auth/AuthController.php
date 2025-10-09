<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth\LoginService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly LoginService $loginService) {}

    public function login(LoginRequest $request)
    {
        // Validate the request using LoginRequest
        $request->authenticate();

        // Delegate authentication + redirect logic to service
        return $this->loginService->authenticate($request);
    }

    public function logout(Request $request)
    {
        return $this->loginService->logout($request);
    }
}
