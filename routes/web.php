<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/home')->group(function() {
    Route::get('/', [WebController::class, 'showHome'])->name('web.home');

    Route::post('/record', [WebController::class, 'record'])->name('web.home.record');
});
