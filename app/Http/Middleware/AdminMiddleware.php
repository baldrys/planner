<?php

namespace App\Http\Middleware;

use Closure;
use App\Support\Enums\UserRoleEnum;
use Illuminate\Auth\Access\AuthorizationException;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->getRole() == UserRoleEnum::Admin) {
            return $next($request);
        } else
            throw new AuthorizationException("This action is only for admin");
    }
}
