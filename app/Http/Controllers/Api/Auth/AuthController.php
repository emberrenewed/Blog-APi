<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $result = $action->handle($request->validated());

        return response()->json($result, 201);
    }

    public function login(LoginRequest $request, LoginAction $action)
    {
        $result = $action->handle($request->validated());

        if (!$result) {
            return response()->json(['message' => 'Wrong email or password.'], 401);
        }

        return response()->json($result);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
