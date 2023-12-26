<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\Comment\CommentController::class)
    ->group(function (): void {
        Route::get('comments', 'index')
            ->name('index');

        Route::post('comments', 'store')
            ->name('store');

        Route::get('comments/{comment}', 'show')
            ->name('show');

        Route::patch('comments/{comment}', 'update')
            ->name('update');

        Route::delete('comments/{comment}', 'destroy')
            ->name('destroy');
    });
