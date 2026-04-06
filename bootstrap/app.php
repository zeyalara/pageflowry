<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'creator' => App\Http\Middleware\CreatorMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (PostTooLargeException $e, Request $request) {
            if (! $request->expectsJson() && ! $request->ajax()) {
                return null;
            }

            return response()->json([
                'message' => sprintf(
                    'Ukuran request melebihi batas PHP (post_max_size=%s, upload_max_filesize=%s). '
                    .'Edit php.ini atau gunakan public/.user.ini. '
                    .'Jika pakai Nginx, tambah client_max_body_size (lihat deploy/nginx-upload-limits.conf).',
                    ini_get('post_max_size'),
                    ini_get('upload_max_filesize')
                ),
            ], 413);
        });
    })->create();
