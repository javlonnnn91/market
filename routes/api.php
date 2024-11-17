<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfitController;

Route::post('purchase', [PurchaseController::class, 'store']);
Route::post('refund', [RefundController::class, 'store']);
Route::get('product', [ProductController::class, 'index']);
Route::post('order', [OrderController::class, 'store']);
Route::get('profit', [ProfitController::class, 'profit']);
