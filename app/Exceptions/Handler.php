<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $exception, $request) {
            switch ($exception) {

                case $exception instanceof RecordsNotFoundException
                    or $exception instanceof NotFoundHttpException
                    or $exception instanceof FileNotFoundException
                    or $exception instanceof RouteNotFoundException:
                    if ($request->wantsJson()) {
                        return Controller::getJsonResponse('not found', [], false, 404);
                    }
                    return response()->view('errors.404');
                case $exception instanceof ValidationException:
                    if ($request->wantsJson()) {
                        return Controller::getJsonResponse('invalid_data', $exception->errors(), false, 422);
                    }
                    return back()->with($exception->errors(), 422);
                default:
                    if ($request->wantsJson()) {
                        return Controller::getJsonResponse('Internal Serve error', $exception->getMessage(), false, 500);
                    }
                    return response()->view('errors.500');
            }
        });
    }
}
