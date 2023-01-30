<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\FrontEnd\CardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontEnd\ReviewController;
use App\Http\Controllers\FrontEnd\AddressController;
use App\Http\Controllers\FrontEnd\WelcomeController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\FrontEnd\CustomerItemController;
use App\Http\Controllers\FrontEnd\CustomerOrderController;
use App\Http\Controllers\FrontEnd\UserController as UserFrontEnd;
use App\Http\Controllers\Admin\AddressController as AdminAddressController;

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

Route::get("/privacy-policy", function(){
    return View::make("FrontEnd.privace");
 });

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

// Route for reviews
Route::resource('reviews', ReviewController::class)->middleware('auth');


// route for login with github
Route::get('/sign-in/github', [LoginController::class, 'github']);
Route::get('/sign-in/github/redirect', [LoginController::class, 'githubRedirect']);

// Route::post(config('eu-cookie-consent.route'), ['uses' => '\the42coders\EuCookieConsent\Http\Controllers\EuCookieConsentController@saveCookie']);
/* 
Routes for user's profile
 */
Route::resource('users', UserFrontEnd::class)->middleware('auth');

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
    Route::get('/show-small-card', 'showSmallCard')->name('showSmallCard');
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
    Route::resource('/messages' , MessageController::class);
    // calendar
    Route::get('/calendar', [FullCalendarController::class, 'index'])->name('calendar');
    Route::get('calendar/create-event', [FullCalendarController::class, 'form'])->name('CalendarForm');
    Route::post('calendar/create', [FullCalendarController::class, 'create'])->name('create_event');
    Route::post('calendar/update', [FullCalendarController::class, 'update']);
    Route::post('calendar/delete', [FullCalendarController::class, 'destroy']);

});

Auth::routes(['verfiy' => true]);

// Route for email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/')->with(['info' => 'Podarilo sa overiť mail.', 'type' => 'success']);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/registration/verify-email', [WelcomeController::class, 'verifyMail']);

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with(['info' => 'Odoslali sme ti overovací link.', 'type' => 'success']);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/home', [HomeController::class, 'index'])->name('home');
