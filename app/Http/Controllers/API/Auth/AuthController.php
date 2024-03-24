<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\{LoginRequest,SignupRequest};

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');
        $token = $this->authService->login($credentials, $remember);

        return response()->json(['token' => $token]);
    }

    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        $user = $this->authService->signup($data);

        return response()->json(['message' => 'Signup successful', 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
