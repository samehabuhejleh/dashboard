<?php

use App\Http\Controllers\SuperAdmin\DashboardController as SuperDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProductController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SuperAdmin\OrderController as SuperOrderController;

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

    Route::get('/products/{product}', [HomeController::class, 'showProduct'])->name('products.show');
    Route::post('/cart/add', [CartController::class, 'AddToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::delete('/cart/delete/{id}', [CartController::class, 'deleteItem'])->name('cart.delete');
    
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


    Route::prefix('orders')->as('order.')->group(function () {
        Route::get('/', [SuperOrderController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [SuperOrderController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SuperOrderController::class, 'update'])->name('update');
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

Route::group(['middleware'=>'user'],function(){

    Route::get('/checkout', [PaymentController::class, 'showCheckout'])->name('payment.form');
    Route::post('/checkout', [PaymentController::class, 'processPayment'])->name('payment.process');
    
});


Route::middleware('auth')->group(function () {
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
   Route::get('/messages/{receiverId}', [MessageController::class, 'getMessages']);
   Route::get('/chat', [MessageController::class, 'index']);
   Route::get('/users', [MessageController::class, 'getAllUsers']);
});
