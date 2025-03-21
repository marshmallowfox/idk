<?php

use App\Http\Middleware\XDebugMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(XDebugMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                $status = 500;
                $errors = ['message' => $e->getMessage()];

                if ($e instanceof ValidationException) {
                    $status = 422;
                    $errors = $e->errors();
                } elseif ($e instanceof NotFoundHttpException) {
                    $status = 404;
                    $errors = ['message' => 'Ресурс не найден'];
                }

                return response()->json([
                    'success' => false,
                    'errors' => $errors
                ], $status);
            }

            return null;
        });
    })->create();
