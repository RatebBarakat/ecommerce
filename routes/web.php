<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\BrandController as FrontBrandController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Models\Admin;
use App\Models\User;
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

Route::get('login', function () {
    auth()->login(Admin::first());
});

Route::get('/',[HomeController::class,'home']);

Route::prefix('user')->name('user.')->group(function ()
{
   Route::middleware(['guest','throttle:only_five_login_fail'])->group(function(){
        Route::post('/login',[UserController::class,'login'])->name('login');
   }); 
   Route::middleware('auth')->group(function(){
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
   });
   Route::get('/checkout',[checkoutController::class,'create'])->name('checkout');
   Route::post('/checkout/store',[checkoutController::class,'store'])->name('checkout.store');

   Route::get('/category/{category_id}',[CategoryController::class,'index'])->name('category.detail');
   Route::get('/product/{id}/detail',[ProductController::class,'index'])->name('product.detail');
   Route::get('/category/brand/{id}/detail',[FrontBrandController::class,'index'])
          ->name('brand.detail');
//    Route::get('/test',[Controller::class,'index']);
});
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function(){
    Route::post('/logout',[UserController::class,'adminLogout'])->name('logout');
    Route::view('/','admin.dashboard');
    Route::view('/users','admin.users')->name('users');
    Route::view('/categories','admin.categories')->name('categories');
    Route::view('/brands','admin.brands')->name('brands');
    Route::view('/products','admin.products')->name('products');
    Route::get('/users/{id}/edit',[AdminUserController::class,'edit'])->name('users.edit');
    Route::get('/categories/{id}/edit',[CategoryController::class,'edit'])
    ->name('categories.edit');
    Route::get('/brands/{id}/edit',[BrandController::class,'edit'])
    ->name('brands.edit');
});