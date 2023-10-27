<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

//use Throwable;
use Illuminate\Auth\AuthenticationException;
use Throwable;

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
        $this->renderable(function (AuthenticationException $e, $request) {
            //
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'code' => 401,
                        'message' => 'Lỗi đăng nhập'
                    ], 401
                );
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException && $request->is('storage/uploads/*')) {
            $headers = [
                'Content-Type' => 'image/jpeg', // Set the appropriate MIME type for your image
            ];
            $imagePath = public_path('/img/sayo-default-vertical.webp');
            return response()->file($imagePath, $headers);
        }

        return parent::render($request, $exception);
    }
}
