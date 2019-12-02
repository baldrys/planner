<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    // public function getUser(User $user) {
    //     // throw new BadRequestHttpException('EXEPTION!!!!');
    //     return new UserResource($user);
    // }

    public function getUser(User $user) {
        dd($user->getRole());
        return new UserResource($user);
    }


}
