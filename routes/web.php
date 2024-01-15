<?php

use Illuminate\framework\factory\Route;
use App\controllers\admin\HomeController;
use App\controllers\admin\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/admin/products', [ProductController::class, 'index']);
Route::get('/admin/product/new', [ProductController::class, 'store']);
Route::post('/admin/product/new', [ProductController::class, 'store']);
Route::post('/admin/product/destroy/{param}', [ProductController::class, 'destroy']);
Route::post('/admin/product/edit/{param}', [ProductController::class, 'edit']);