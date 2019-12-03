<?php

namespace App\Services;

use GuzzleHttp\Exception\BadResponseException;
use App\Http\Requests\Auth\LoginUserRequest;
use GuzzleHttp\Client;
use App\Exceptions\AppException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpRequestService{

    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client;

    }

    public function sendLoginRequest(LoginUserRequest $request) {
        try {
            $response = $this->httpClient->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch(BadResponseException $e) {
            if ($e->getCode() === 400) {
                throw new HttpException($e->getCode(), 'Invalid Request. Please enter a username or a password.');
            } else if ($e->getCode() === 401) {
                throw new HttpException($e->getCode(), 'Your credentials are incorrect. Please try again.');
            }
            throw new HttpException($e->getCode(), 'Something went wrong on the server.');
        }
        
    }
}