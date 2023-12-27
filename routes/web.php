<?php

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
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
Route::get('/category/{name}', [CategoryController::class, 'categoryNewsShow'])->name('category');

// مسیر های ادمین
Route::group(['middleware' => 'admin','prefix' => 'admin'], function () {

    // اخبار
    Route::controller(AdminNewsController::class)->group(function () {
        Route::group(['prefix' => 'dashboard'], function () {
            // دسترسی به اخبار
            Route::get('/', 'adminPanel')->name('admin.dashboard');

            // اضافه کردن خبر جدید
            Route::get('/news-add', 'showNewsAdd')->name('admin.newsAdd');
            Route::post('/news-add', 'newsAdd')->name('newsAdd');

            // ویرایش خبر
            Route::get('/news-edit/{id}', 'showNewsEdit')->name('admin.newsEdit');
            Route::post('/news-edit/{id}', 'newsEdit')->name('newsEdit');

            // حذف خبر
            Route::get('/news-remove/{id}', 'newsRemove')->name('news.remove');
            Route::get('/news-hide/{id}', 'newsHide')->name('news.hide');

            // آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
            Route::get('/news-visible/{id}', 'newsVisible')->name('news.visible');
        });

    });

    // دسته‌بندی ها
    Route::controller(AdminCategoryController::class)->group(function () {
        Route::group(['prefix' => 'category'], function () {
            // دسترسی به دسته‌بندی ها
            Route::get('/', 'adminCategory')->name('admin.category');
            
            // اضافه کردن دسته‌بندی
            Route::get('/add', 'showCategoryAdd')->name('admin.categoryAdd');
            Route::post('/add', 'addCategory')->name('categoryAdd');

            // ویرایش دسته‌بندی
            Route::get('/edit/{id}', 'showCategoryEdit')->name('admin.editCategory');
            Route::post('/edit/{id}', 'categoryEdit')->name('editCategory');

            // دسته‌بندی
            Route::get('/hide/{id}', 'categoryHide')->name('category.hide');

            // آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
            Route::get('/remove/{id}', 'categoryRemove')->name('category.remove');
            Route::get('/visible/{id}', 'categoryVisible')->name('category.visible');

            // نمایش اخبار مربوط به هر دسته‌بندی
            Route::get('/show/{name}', 'categoryNewsShow')->name('category.show');
        });            
    });

    // ادمین ها
    Route::controller(AdminController::class)->group(function () {
        Route::group(['prefix' => 'admins'], function () {
            // لیست ادمین ها
            Route::get('/', 'adminList')->name('admin.list');

            // افزودن ادمین
            Route::get('/add', 'showAdminAdd')->name('admin.adminsAdd');
            Route::post('/add', 'adminAdd')->name('adminsAdd');
        });            
    });
});