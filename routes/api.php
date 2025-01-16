<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::namespace('Admin')->prefix('admins')->group(function () {

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {



        Route::prefix('categories')->group(function (){
            Route::get('index', [CategoryController::class,'index']);

        });

        Route::prefix('products')->group(function (){

            Route::get('index', [ProductController::class, 'index']);
            Route::post('store', [ProductController::class, 'store'])->name('products.store');
            Route::get('show/{id}', [ProductController::class, 'show']);
            Route::post('update/{id}', [ProductController::class, 'update']);
            Route::post('delete/{id}', [ProductController::class, 'destroy']);
        });

    });

});


Route::namespace('Customer')->prefix('customers')->group(function () {


    Route::middleware(['auth:sanctum', 'customer'])->group(function () {

        Route::prefix('products')->group(function (){

            Route::get('index', [\App\Http\Controllers\Customer\ProductController::class, 'index']);
            Route::get('show/{id}', [\App\Http\Controllers\Customer\ProductController::class, 'show']);

        });




        Route::prefix('orders')->group(function (){

            Route::get('index', [OrderController::class, 'index']);
            Route::post('place-order', [OrderController::class, 'placeOrder'])->name('orders.place-order');
            Route::get('orderDetails/{id}', [OrderController::class, 'show']);

        });

    });

});
