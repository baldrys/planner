<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;

trait ApiExceptionTrait
{
	public function apiException($request, $exception)
	{
        if ($exception instanceof NotFoundHttpException) {
            $response['message'] = "Resource not found.";
            $statusCode = $exception->getStatusCode();
        }
        else if ($exception instanceof ModelNotFoundException) {
            $ids = $exception->getIds();
            $id = count($exception->getIds()) === 1 ? $ids[0] : $ids;
            $s = explode("\\", $exception->getModel());
            $model = end($s);
            $response['message'] = "{$model} with id {$id} was not found";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        else if ($exception instanceof ValidationException) {
            $response['message'] = $exception->getMessage();
            $response['errors'] = $exception->errors();
            $statusCode = $exception->status;
        } 
        else if($exception instanceof AuthorizationException){
            $response['message'] = $exception->getMessage();
            $statusCode = Response::HTTP_FORBIDDEN;
        }
        else {
            //return parent::render($request, $exception);
            $response['message'] = $exception->getMessage();
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        return response()->json($response, $statusCode);
    }
    

}