<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\UserOrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['auth:sanctum', 'verified'], function () {

    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    Route::get('/product/factory', [ProductController::class, 'trigerFactory'])->name('product.trigerFactory');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::patch('/product/edit/{id}', [ProductController::class, 'update'])->name('product.edit');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/user/carts', [UserCartController::class, 'index'])->name('carts.index');
    Route::post('/user/carts', [UserCartController::class, 'store'])->name('carts.store');
    Route::delete('/user/carts/delete/{id}', [UserCartController::class, 'delete'])->name('carts.delete');

    Route::post('/place/order', [UserCartController::class, 'placeOrder'])->name('order.store');

    Route::get('/user/orders', [UserOrderController::class, 'index'])->name('orders.index');

});
