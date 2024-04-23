<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->wantsJson()) {
                return response()->api([], 1, $e->errors(), statusCode:$e->status);
            }
        });

        $this->renderable(function (QueryException $e, $request) {
            $statusCode = gettype($e->getCode()) == 'integer' && strlen((string) $e->getCode()) == 3?$e->getCode():500;

            if ($request->wantsJson()) {
                return response()->api([], 1, $e->getMessage(), statusCode:$statusCode);
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            $statusCode = gettype($e->getCode()) == 'integer' && strlen((string) $e->getCode()) == 3?$e->getCode():403;
            if ($request->wantsJson()) {
                return response()->api([], 1, $e->getMessage(), statusCode:$statusCode);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            $statusCode = gettype($e->getCode()) == 'integer' && strlen((string) $e->getCode()) == 3?$e->getCode():404;
            if ($request->wantsJson()) {
                return response()->api([], 1, $e->getMessage(), statusCode:$statusCode);
            }
        });

    }
}
