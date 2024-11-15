<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfitController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('purchase', [PurchaseController::class, 'store']);
Route::post('refund', [RefundController::class, 'store']);
Route::get('product', [ProductController::class, 'index']);
Route::post('order', [OrderController::class, 'store']);
Route::get('profit/{batch_id}', [ProfitController::class, 'profit']);
