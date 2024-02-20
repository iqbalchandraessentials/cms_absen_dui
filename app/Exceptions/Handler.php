<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Database\QueryException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->view('errors.404', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof AuthorizationException) {
            return response()->view('errors.404', [
                'code' => "ERROR",
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof HttpException) {
            return response()->view('errors.404', [
                'code' => '404',
                'message' => "Halaman Tidak Ditemukan",
            ]);
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [
                'code' => "ERROR",
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof TokenMismatchException) {
            return response()->view('errors.404', [
                'code' => "ERROR",
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof ValidationException) {
            return response()->view('errors.404', [
                'code' => "ERROR",
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof ErrorException) {
            return response()->view('errors.404', [
                'code' => "ERROR",
                'message' => $exception->getMessage()
            ]);
        } elseif ($exception instanceof QueryException) {
            return response()->view('errors.404', [
                'code' => "DB_ERROR",
                'message' => $exception->getMessage()
            ]);
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = Arr::get($exception->guards(), 0);

        $route = 'login';

        if ($guard == 'member') {
            // $route = 'member.login';
            $route = 'home';
        }

        return redirect()->route($route);
    }
}
