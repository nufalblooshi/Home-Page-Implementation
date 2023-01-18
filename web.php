<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/add-product', [HomeController::class, 'add_product']);
Route::get('/shop', [HomeController::class, 'shop']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/inc-quantity', [HomeController::class, 'inc_quantity']);
Route::get('/dec-quantity', [HomeController::class, 'dec_quantity']);
Route::get('/del-product', [HomeController::class, 'del_product']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'can:is_admin'])->prefix('/admin')->group(function () {
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
});