<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\User\UserController::class)
    ->group(function (): void {
        Route::get('users', 'index')
            ->name('index');

        Route::post('users', 'store')
            ->name('store');

        Route::get('users/{user}', 'show')
            ->name('show');

        Route::patch('users/{user}', 'update')
            ->name('update');

        Route::delete('users/{user}', 'destroy')
            ->name('destroy');
    });
