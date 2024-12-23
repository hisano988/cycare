<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use App\Http\Middleware\StoreLoginUserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', StoreLoginUserMiddleware::class])->group(function () {
    Route::prefix('/home')->group(function () {
        Route::get('/', [WebController::class, 'showHome'])->name('web.home');

        Route::post('/record', [WebController::class, 'record'])->name('web.home.record');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // メールアドレス認証が必要なルート
    });
});

require __DIR__.'/auth.php';
