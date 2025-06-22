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
    Route::get('logout', [AuthController::class, 'logout']);
    Route::resource('customers', CustomerController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('merchants', MerchantController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('orders', OrderController::class);
    Route::get("/rand-menu", [MenuController::class, "getRandomMenu"]);
    Route::get("/merchant/order", [OrderController::class, "merchantGetOrder"]);
    Route::get("/order/current", [OrderController::class, "getCurrentOrder"]);
    Route::post("/driver/order", [OrderController::class, "driverGetOrder"]);
    Route::post("/driver/order/{id}", [OrderController::class, "driverTakeOrder"]);
    Route::put("/driver/order/{id}", [OrderController::class, "updateStatusOrder"]);
    Route::get("/history/driver", [OrderController::class, "driverHistoryOrder"]);
    Route::get("/history/merchant", [OrderController::class, "merchantHistoryOrder"]);
});
