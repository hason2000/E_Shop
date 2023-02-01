<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('v1/products', \App\Http\Controllers\Api\ProductController::class);
Route::get('v1/products/malls/{mall}/posts',[\App\Http\Controllers\Api\ProductController::class, 'test']);
