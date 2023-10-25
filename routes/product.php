<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/products', [ProductController::class, 'index']);

Route::get("/product/{id}", [ProductController::class, 'show']);

