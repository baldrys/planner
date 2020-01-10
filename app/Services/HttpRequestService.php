<?php

namespace App\Services;

use GuzzleHttp\Exception\BadResponseException;
use App\Http\Requests\Auth\LoginUserRequest;
use GuzzleHttp\Client;
use App\Exceptions\AppException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Request;
class HttpRequestService{

    public function sendLoginRequest(LoginUserRequest $request) {
            $tokenRequest = Request::create(config('services.passport.login_endpoint'), 'post', 
                [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            );
            $response = app()->handle($tokenRequest);
            $statusCode = $response->status();
            if ($statusCode !== Response::HTTP_OK ) {
                if ($statusCode === Response::HTTP_BAD_REQUEST) {
                    throw new HttpException($statusCode, 'Invalid Request. Please enter a username or a password.');
                } else if ($statusCode === Response::HTTP_UNAUTHORIZED) {
                    throw new HttpException($statusCode, 'Your credentials are incorrect. Please try again.');
                }
                throw new HttpException($statusCode, 'Something went wrong on the server.');
            };
            return $response->content();
        
    }
}