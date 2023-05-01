<?php

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

Route::get('/locale/{locale?}', [App\Http\Controllers\HomeController::class, 'update_locale'])->name('locale.update');
Route::get('/currency/{currency_id?}', [App\Http\Controllers\HomeController::class, 'update_currency'])->name('currency.update');

Route::get('/privacy', [App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');

Route::get('/loginUsingId/{user_id}', [App\Http\Controllers\AuthController::class, 'loginUsingId'])->name('loginUsingId');

Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/contact_func', [App\Http\Controllers\HomeController::class, 'contact_func'])->name('contact_func');

// Guest Section
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register/{user_type?}', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register_func'])->name('register_func');
    
    Route::get('/otp/verify', [App\Http\Controllers\AuthController::class, 'verify_otp'])->name('verify_otp');
    Route::post('/otp/verify', [App\Http\Controllers\AuthController::class, 'verify_otp_func'])->name('verify_otp_func');
    
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login_func'])->name('login_func');
    
    Route::get('/forget', [App\Http\Controllers\AuthController::class, 'forget'])->name('forget');
    
});
// End Auth Section

// guest or auth stuff
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/teacher/{slug?}', [App\Http\Controllers\HomeController::class, 'teacher_details'])->name('teacher');

Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
   Route::post('message/send', [App\Http\Controllers\MessageController::class, 'ajaxSendMessage'])->name('message.new');
});

Route::get('/category/{topic_id}', [App\Http\Controllers\HomeController::class, 'category_details'])->name('category.details');

// show package
Route::get('/package/{package_id}', [App\Http\Controllers\HomeController::class, 'show_package'])->name('package.show');

Route::group(['middleware'=>'auth'], function(){

    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'] )->name('logout');


    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\HomeController::class, 'profile_func'])->name('profile_func');
    Route::post('/upload_image', [App\Http\Controllers\AuthController::class, 'upload_image'])->name('image.store');

    Route::get('/wallet', [App\Http\Controllers\HomeController::class, 'wallet'])->name('wallet');

    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('password.update');

    Route::get('message/{id}', [App\Http\Controllers\MessageController::class, 'chatHistory'])->name('message.read');

    Route::post('payment/checkout', [App\Http\Controllers\StripeController::class, 'checkout'])->name('payment.checkout');

    Route::get('book/{teacher_id}/single', [App\Http\Controllers\OrderController::class, 'book_single'])->name('book.single');
    Route::post('book/{teacher_id}/single', [App\Http\Controllers\OrderController::class, 'book_single_func'])->name('book.single_func');


    Route::get('/lessons', [App\Http\Controllers\OrderController::class, 'lessons'])->name('lessons');

    Route::post('/review', [App\Http\Controllers\HomeController::class, 'add_review'])->name('review.add');

    Route::get('/review/{student_id}', [App\Http\Controllers\HomeController::class, 'add_student_review'])->name('review.student.add');


    // teacher stuff

        // show packages
        Route::get('/packages', [App\Http\Controllers\HomeController::class, 'packages'])->name('packages');


        // add-update package
        Route::get('/package/add/{package?}', [App\Http\Controllers\HomeController::class, 'add_package'])->name('packages.add');

        // add-update package functionality
        Route::post('/package', [App\Http\Controllers\HomeController::class, 'update_package'])->name('package.update');


    // student stuff


        // book package
        Route::post('package/{package_id}', [App\Http\Controllers\OrderController::class, 'book_package_func'])->name('book.package_func');

    
});




Route::get('meet', [App\Http\Controllers\HomeController::class, 'meet'])->name('meet');