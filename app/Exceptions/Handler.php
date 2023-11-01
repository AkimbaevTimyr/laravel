<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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
    public function register()
    {
        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->view('errors.unauthorized', [
                'message' => 'У вас нету доступа к этой странице',
            ], 403);
        });

        $this->renderable(function(NotFoundHttpException $e, Request $request) {
            if($request->is('api/*')) {
                return response()->json([
                    'message'=> 'End Point Not Found',
                ], 404);
            }
            if($request->is('web/*')) {
                return response()->json([
                    'message' => 'Page Not Found'
                ], 404);
            }
        });
    }
}
