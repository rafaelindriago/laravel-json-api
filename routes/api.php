<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('users.')
    ->group(__DIR__ . '\resources\users.php');

Route::name('tags.')
    ->group(__DIR__ . '\resources\tags.php');

Route::name('posts.')
    ->group(__DIR__ . '\resources\posts.php');

Route::name('comments.')
    ->group(__DIR__ . '\resources\comments.php');
