<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::resource('products', ProductController::class);
Auth::routes();
Route::get('/register/confirm/{token}', [RegisterController::class, 'confirmUser'])->name('register.confirm');
Route::middleware(['auth'])->group(function () {
    Route::resource('cart', CartController::class);
    Route::post('/carts/add_to_cart', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::put('/carts/{cart_id}/plus/{product_size_id}', [CartController::class, 'plusProductCart'])->name('cart.plus');
    Route::put('carts/{cart_id}/minus/{product_size_id}', [CartController::class, 'minusProductCart'])->name('cart.minus');
    Route::put('cart/{cart_id}/change_quantity/{product_size_id}', [CartController::class, 'changeQuantity'])->name('cart.change_quantity');
    Route::delete('carts/{cart_id}/delete/{product_size_id}', [CartController::class, 'deleteProductInCart'])->name('cart.delete_product');
    Route::post('chat/{shop_id}', [\App\Http\Controllers\User\ChatController::class, 'sendMessage'])->name('user.chat');
});