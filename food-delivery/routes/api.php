<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DriverController;
use App\Http\Controllers\api\MenuController;
use App\Http\Controllers\api\MerchantController;
use App\Http\Controllers\api\OrderController;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('customers', CustomerController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('merchants', MerchantController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('orders', OrderController::class);
});
