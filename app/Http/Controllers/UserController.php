<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse{
       return $this->authService->register($request);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse{
        return $this->authService->login($request);
    }

    public function logout(): \Illuminate\Http\JsonResponse{
        return $this->authService->logout();
    }
}
