<?php

use App\Http\Controllers\Admin\AddressController as AdminAddressController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\FrontEnd\CardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontEnd\WelcomeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\FrontEnd\AddressController;
use App\Http\Controllers\FrontEnd\CustomerItemController;
use App\Http\Controllers\FrontEnd\CustomerOrderController;

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

Route::get('/', [WelcomeController::class, 'index']);

// Route for item
Route::controller(CustomerItemController::class)->name('item.')->prefix('item')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

// Route for address
Route::controller(AddressController::class)->name('address.')->prefix('address')->group(function () {
    Route::get('/', 'createUserAddress')->name('createUserAddress');
    Route::post('/', 'storeUserAddress')->name('storeUserAddress');
    Route::get('/order-address', 'createOrderAddress')->name('createOrderAddress');
    Route::post('/order-address', 'storeOrderAddress')->name('storeOrderAddress');
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
    Route::post('/store', 'storeInSession')->name('store');
    Route::post('/update-item', 'updateItem')->name('update');
    Route::post('/remove-item', 'removeItem')->name('remove');
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
    Route::resource('/addresses' , AdminAddressController::class);
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
