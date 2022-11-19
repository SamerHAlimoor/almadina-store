<?php

use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ImportProductController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesContorller;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Middleware\CheckUserType;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:admin'],
    'as' => 'dashboard.', // for name نفس فكرة الاسم يعني  = ->name('dashboard.categories.index')
    'prefix' => 'admin/dashboard', // this for prefix
    //'namespace' => 'App\Http\Controllers\Dashboard',
], function () {



    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('/categories/trash', [CategoryController::class, 'trash'])
        ->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
        ->name('categories.force-delete');

    //to import products
    Route::get('products/import', [ImportProductController::class, 'create'])
        ->name('products.import');
    Route::post('products/import', [ImportProductController::class, 'store']);

    

    Route::resources([
        'products' => ProductsController::class,
        'categories' => CategoryController::class,
        'roles' => RolesContorller::class,
        'users' => UsersController::class,
        'admins' => AdminsController::class,
    ]);
});