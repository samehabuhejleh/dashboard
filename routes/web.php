<?php

use App\Http\Controllers\SuperAdmin\DashboardController as SuperDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProductController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'welcome'])->name('welcome');

Route::middleware('auth')->group(function(){
Route::get('/product/{id}',[HomeController::class,'showProduct'])->name('show');

});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('super-admin')->as('super.')->middleware(['super_admin'])->group(function () {

    Route::get('/index', [SuperDashboardController::class, 'index'])->name('index');

    Route::prefix('products')->as('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    });

    Route::prefix('users')->as('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
});
Route::prefix('admin')->as('admin.')->middleware(['admin'])->group(function () {
    Route::get('/index', [AdminDashboardController::class, 'index'])->name('index');
});
Route::prefix('user')->as('user.')->middleware(['user'])->group(function () {
    Route::get('/index', [UserDashboardController::class, 'index'])->name('index');
});
