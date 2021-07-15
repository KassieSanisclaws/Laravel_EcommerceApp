<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendProductListController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SlidersController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'App\Http\Controllers\FrontendProductListController@index');
Route::get('/product/{id}', 'App\Http\Controllers\FrontendProductListController@show')->name('product.view');
Route::get('/category/{name}', 'App\Http\Controllers\FrontendProductListController@allProduct')->name('product.list');
Route::get('/addToCart/{product}', 'App\Http\Controllers\CartController@addToCart')->name('add.cart');
Route::get('/cart', 'App\Http\Controllers\CartController@showCart')->name('cart.show');
Route::get('/orders', 'App\Http\Controllers\CartController@order')->name('order')->middleware('auth');
Route::get('/checkout/{amount}', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::post('/charge', 'App\Http\Controllers\CartController@charge')->name('cart.charge');
Route::post('/products/{product}', 'App\Http\Controllers\CartController@updateCart')->name('cart.update');
Route::post('/product/{product}', 'App\Http\Controllers\CartController@removeCart')->name('cart.remove');


Auth::routes();

Route::get('/all/products', 'App\Http\Controllers\FrontendProductListController@moreProducts')->name('more.product');
// Below is the main home controller view. //
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Below is the middleware for the admin authentication route user. //
Route::group(['prefix'=>'auth', 'middleware'=>['auth', 'isAdmin']], 
      function(){ Route::get('/dashboard', function(){
                return view('admin.dashboard');
});

// Below are the controllers for the categories. //
Route::resource('category', 'App\Http\Controllers\CategoryController');
Route::resource('subcategory', 'App\Http\Controllers\SubcategoryController');
Route::resource('product', 'App\Http\Controllers\ProductController');
// Below is product routes. //
Route::get('subcategories/{id}', 'App\Http\Controllers\ProductController@loadSubCategories');
Route::resource('product', 'App\Http\Controllers\ProductController');
Route::get('user/orders', 'App\Http\Controllers\ProductController@userOrder');
// Below is slider routes. //
Route::get('slider/create', 'App\Http\Controllers\SlidersController@create')->name('slider.create');
Route::get('slider', 'App\Http\Controllers\SlidersController@index')->name('slider.index');
Route::post('slider', 'App\Http\Controllers\SlidersController@store')->name('slider.store');
Route::delete('slider/{id}', 'App\Http\Controllers\SlidersController@destroy')->name('slider.destroy');
// Below is user routes. //
Route::get('users', 'App\Http\Controllers\UserController@index')->name('user.index');
});