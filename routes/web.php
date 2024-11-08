<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineTestController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


// Webhook 路由 - 允許任何方法
Route::match(['get', 'post'], '/linetest', [LineTestController::class, 'post']);

Route::post('/post-endpoint', [LineTestController::class, 'post']);

