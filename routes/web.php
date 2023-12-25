<?php

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\NewsController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/news-details/{id}', [NewsController::class, 'newsDetails'])->name('details');

// مسیر های ادمین
Route::group(['middleware' => 'admin','prefix' => 'admin'], function () {
    Route::controller(AdminNewsController::class)->group(function(){
        Route::get('/dashboard', 'adminPanel')->name('admin.dashboard');
        Route::get('/news-add', 'showNewsAdd')->name('admin.newsAdd');
        Route::post('/news-add', 'newsAdd')->name('newsAdd');
    });
});