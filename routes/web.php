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

// Auth Section
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

Route::get('/teacher/{slug?}', [App\Http\Controllers\HomeController::class, 'teacher_details'])->name('teacher');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::post('/profile', [App\Http\Controllers\HomeController::class, 'profile_func'])->name('profile_func');
Route::post('/upload_image', [App\Http\Controllers\AuthController::class, 'upload_image'])->name('image.store');

Route::get('/wallet', [App\Http\Controllers\HomeController::class, 'wallet'])->name('wallet');

Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('password.update');


Route::get('message/{id}', [App\Http\Controllers\MessageController::class, 'chatHistory'])->name('message.read');

Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
   Route::post('message/send', [App\Http\Controllers\MessageController::class, 'ajaxSendMessage'])->name('message.new');
});


Route::group(['middleware'=>'auth'], function(){

    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'] )->name('logout');

    Route::group(['middleware'=>'teacher'], function(){
       
    });
});



// Admin Section
Route::get('admin/user/list', [App\Http\Controllers\Admin\UserController::class, 'list_api'])->name('admin.user.list');

Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::resource('/user', App\Http\Controllers\Admin\UserController::class);
    
    Route::resource('/student', App\Http\Controllers\Admin\StudentController::class);
    Route::resource('/teacher', App\Http\Controllers\Admin\TeacherController::class);
    Route::resource('/topic', App\Http\Controllers\Admin\TopicController::class);
    Route::resource('/level', App\Http\Controllers\Admin\LevelController::class);
    Route::resource('/language', App\Http\Controllers\Admin\LanguageController::class);
    Route::resource('/language_level', App\Http\Controllers\Admin\LanguageLevelController::class);
    Route::resource('/currency', App\Http\Controllers\Admin\CurrencyController::class);
    Route::resource('/course', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('/country', App\Http\Controllers\Admin\CountryController::class);
});
// End Admin Section




Route::post('payment/checkout', [App\Http\Controllers\StripeController::class, 'checkout'])->name('payment.checkout');

Route::get('book/{teacher_id}/single', [App\Http\Controllers\OrderController::class, 'book_single'])->name('book.single');
Route::post('book/{teacher_id}/single', [App\Http\Controllers\OrderController::class, 'book_single_func'])->name('book.single_func');


Route::get('/lessons', [App\Http\Controllers\OrderController::class, 'lessons'])->name('lessons');


// teacher stuff

    // show packages
    Route::get('/packages', [App\Http\Controllers\HomeController::class, 'packages'])->name('packages');


    // add-update package
    Route::get('/package/add/{package?}', [App\Http\Controllers\HomeController::class, 'add_package'])->name('packages.add');

    // add-update package functionality
    Route::post('/package', [App\Http\Controllers\HomeController::class, 'update_package'])->name('package.update');


// student stuff

    // show package
    Route::get('/package/{package_id}', [App\Http\Controllers\HomeController::class, 'show_package'])->name('package.show');

    // book package
    Route::post('package/{package_id}', [App\Http\Controllers\OrderController::class, 'book_package_func'])->name('book.package_func');

    