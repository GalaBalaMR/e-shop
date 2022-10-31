<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\FrontEnd\CardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontEnd\CustomerOrderController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

/* 
Routes for customer orders
Just for authenticated user
 */
Route::resource('orders', CustomerOrderController::class)->middleware('auth');

/* 
Routes for card, where we use session 'items' for transporting data
 */
Route::controller(CardController::class)->name('card.')->prefix('card')->group(function () {
    Route::get('/show', 'showCard')->name('show');
    Route::get('/store', 'storeInSession')->name('store');
    Route::get('/update-item', 'updateItem')->name('update');
    Route::get('/remove-item', 'removeItem')->name('remove');
});

// admin routes,
// for role admin, manager, service
Route::middleware(['role:Admin|Service|Manager'])->name('admin.')->prefix('admin')->group(function() {
    Route::get('/' , [AdminController::class, 'index'])->name('index');
    Route::resource('/users' , UserController::class);
    Route::resource('/categories' , CategoryController::class);
    Route::resource('/subcategories' , SubCategoryController::class);
    Route::resource('/items' , ItemController::class);
    Route::resource('/orders' , OrderController::class);
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
