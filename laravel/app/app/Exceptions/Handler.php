<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (AuthenticationException $e) {
            return response()->json([
                'message' => __($e->getMessage()),
                'text_code' => 'UNAUTHENTICATED',
            ], 401);
        });
        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => __('Not found'),
                'text_code' => 'NOT_FOUND',
            ], 404);
        });
        $this->renderable(function (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'text_code' => 'ERROR',
            ], $e->getCode() ?: 400);
        });
    }
}
