<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;


trait ApiExceptionTrait
{
	public function apiException($request, $exception)
	{
        if ($exception instanceof HttpException) {
            return response()->json(
                [
                    'error' => $exception->getMessage()
                ], 
                $exception->getStatusCode()
            );
        }
        return parent::render($request, $exception);
	}
}