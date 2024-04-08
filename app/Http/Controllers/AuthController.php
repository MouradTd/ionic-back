<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request)
    {
        return AuthService::register($request);
    }

    public function login(Request $request)
    {
        return AuthService::login($request);
    }

    public function forgetPassword(Request $request)
    {
        return AuthService::forgetPassword($request);
    }

    public function logout()
    {
        return AuthService::logout();
    }
}
