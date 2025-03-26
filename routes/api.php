<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->group(function () {
   
Route::prefix('products')->as('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
});

});



Route::post('/login', [AuthController::class, 'login'])->name('login');





