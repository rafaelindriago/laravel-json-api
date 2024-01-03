<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\Tag\TagController::class)
    ->group(function (): void {
        Route::get('tags', 'index')
            ->name('index');

        Route::post('tags', 'store')
            ->name('store');

        Route::get('tags/{tag}', 'show')
            ->name('show');

        Route::patch('tags/{tag}', 'update')
            ->name('update');

        Route::delete('tags/{tag}', 'destroy')
            ->name('destroy');
    });
