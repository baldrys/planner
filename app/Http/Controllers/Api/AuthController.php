<?php

namespace App\Http\Controllers\Api;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\HttpRequestService;


class AuthController extends Controller
{
    public function login(LoginUserRequest $request, HttpRequestService $httpRequestService)
    {
        return $httpRequestService->sendLoginRequest($request);
    }
    
    
    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return new UserResource($user);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
}
