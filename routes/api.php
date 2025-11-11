<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('/customers', CustomerController::class);
// Route::prefix('/customers')->group(function () {
//     Route::get('/', [CustomerController::class, 'index']);
//     Route::post('/', [CustomerController::class, 'store']);
//     Route::put('/{id}', [CustomerController::class, 'update']);
// });
Route::apiResource('/stocks', StockController::class);
Route::apiResource('/sales', SaleController::class);
