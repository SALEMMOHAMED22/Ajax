<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::post('/delete', 'delete')->name('delete');

            // Edit $ Update  Routes 
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update', 'update')->name('update');

            Route::post('cities', 'getCities')->name('cities');

            //   live search by ajax 
            Route::post('/search', 'search')->name('search');
        });


        Route::prefix('posts')->name('posts.')->controller(PostController::class)->middleware('checkNotificationStatus')->group(function () {
            Route::get('/',  'index')->name('index');
            Route::post('/',  'store')->name('store');
            Route::get('/{post}',  'show')->name('show');
        });

        Route::get('notifications/markAsRead', [NotificationController::class, 'markAsRead'] )->name('notifications.markAsRead');
        Route::get('notifications/{id}/delete', [NotificationController::class, 'delete'] )->name('notifications.delete');
        Route::get('notifications/delete-all', [NotificationController::class, 'deleteAll'] )->name('notifications.deleteAll');
    }

);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
