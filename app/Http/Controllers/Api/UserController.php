<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{

    public function getUsers() {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function getUser(User $user) {
        return new UserResource($user);
    }

    public function addUser(UserCreateRequest $request) {
        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  Hash::make($request->password)
            ]);
        return new UserResource($user);
    }

    public function updateUser(UserUpdateRequest $request, User $user) {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return new UserResource($user);
    }

    public function deleteUser(User $user) {
        $user->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
