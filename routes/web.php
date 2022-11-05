<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;

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


Route::get('/',  [HomeController::class, 'index'])->name('home_page');
Route::get('/products', [ProductsController::class, 'index'])
    ->name('products.index');
Route::resource('cart', CartController::class);


Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);


Route::get('/products/{product:slug}', [ProductsController::class, 'show'])
    ->name('products.show');


require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';