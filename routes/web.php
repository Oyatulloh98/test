<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/admin', AdminController::class);
Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::post('savecart/{save}',[App\Http\Controllers\CartController::class, 'savecart'])->name('Cart-savecart');
Route::post('cleancart/{clean}',[App\Http\Controllers\CartController::class, 'cleancart'])->name('Cart-cleancart');
Route::post('pmfromcart/{id}/{signal}',[App\Http\Controllers\CartController::class, 'pmfromcart'])->name('Cart-pmfromcart');
Route::resource('/cart-items', CartController::class);
Route::controller(WelcomeController::class)->group(function () {
    Route::get('/', 'index')->name('welcome.index');
    Route::post('/orders/{code}', 'store')->name('welcome.order');
    Route::get('/reset', 'reset')->name('welcome.reset');
    Route::get('/delete/{forcedelete}', 'delete')->name('welcome.delete');
    Route::get('/save', 'minus')->name('welcome.save');
    // Route::get('/minusfromcart/{id}/{signal}', 'minusfromcart')->name('welcome.minus');
    Route::get('/sold', 'sold')->name('welcome.sold');
});
