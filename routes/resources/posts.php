<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\Post\PostController::class)
    ->group(function (): void {
        Route::get('posts', 'index')
            ->name('index');

        Route::post('posts', 'store')
            ->name('store');

        Route::get('posts/{post}', 'show')
            ->name('show');

        Route::patch('posts/{post}', 'update')
            ->name('update');

        Route::delete('posts/{post}', 'destroy')
            ->name('destroy');
    });
