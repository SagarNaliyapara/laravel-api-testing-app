<?php

use App\Http\Controllers\BikeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Warehouse
Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
Route::get('warehouses/{id}', [WarehouseController::class, 'show'])->name('warehouses.show');
Route::post('warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
Route::put('warehouses/{id}', [WarehouseController::class, 'update'])->name('warehouses.update');
Route::delete('warehouses/{id}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');

// Bike
Route::get('bikes', [BikeController::class, 'index'])->name('bikes.index');
Route::get('bikes/{id}', [BikeController::class, 'show'])->name('bikes.show');
Route::patch('bikes/{id}', [BikeController::class, 'update'])->name('bikes.update');
Route::post('bikes', [BikeController::class, 'store'])->name('bikes.store');
Route::delete('bikes/{id}', [BikeController::class, 'destroy'])->name('bikes.destroy');

// For getting bike unique models and sizes
Route::get('bike/models', [BikeController::class, 'getBikeModels'])->name('bikes.models');
Route::get('bike/sizes', [BikeController::class, 'getBikeSizes'])->name('bikes.size');

// bikeGraph
Route::get('bike/bikegraph', [BikeController::class, 'getBikeGraph'])->name('bikes.graph');

// Order
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
Route::put('orders/{id}', [OrderController::class, 'update'])->name('orders.update');
