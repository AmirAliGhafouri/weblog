<?php

use App\Http\Controllers\Admin\AdminAdminController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\newsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\UserController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login/{language}', [LoginController::class, 'loginFormLanguage'])->name('login.language');

Route::get('/news-details/{id}', [NewsController::class, 'details'])->name('details');
Route::get('/news-view/{id}', [NewsController::class, 'showViewCount'])->name('news.viewCount');

Route::get('/category/{name}', [CategoryController::class, 'categoryNewsShow'])->name('category');
// Route::get('/test', [HomeController::class, 'test'])->name('test');

// مسیر های کاربر عادی
Route::group(['middleware' => 'auth'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'showUserPanel')->name('user.panel');
        Route::post('/user-edit', 'edit')->name('user.edit');
        Route::get('/user-notfications', 'user_notfications')->name('user.notification');
    });
});

// مسیر های ادمین
Route::group(['middleware' => 'admin','prefix' => 'admin'], function () {

    // اخبار
    Route::controller(AdminNewsController::class)->group(function () {
        Route::group(['prefix' => 'dashboard'], function () {
            // دسترسی به اخبار
            Route::get('/', 'panel')->name('admin.dashboard');

            // اضافه کردن خبر جدید
            Route::get('/news-add', 'add')->name('admin.newsAdd');
            Route::post('/news-add', 'create')->name('newsAdd');

            // ویرایش خبر
            Route::get('/news-edit/{id}', 'edit')->name('admin.newsEdit');
            Route::post('/news-edit/{id}', 'update')->name('newsEdit');

            // حذف خبر
            Route::get('/news-remove/{id}', 'remove')->name('news.remove');
            Route::get('/news-hide/{id}', 'hide')->name('news.hide');

            // آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
            Route::get('/news-visible/{id}', 'visible')->name('news.visible');
        });

    });

    // دسته‌بندی ها
    Route::controller(AdminCategoryController::class)->group(function () {
        Route::group(['prefix' => 'category'], function () {
            // دسترسی به دسته‌بندی ها
            Route::get('/', 'category')->name('admin.category');
            
            // اضافه کردن دسته‌بندی
            Route::get('/add', 'add')->name('admin.categoryAdd');
            Route::post('/add', 'create')->name('categoryAdd');

            // ویرایش دسته‌بندی
            Route::get('/edit/{id}', 'edit')->name('admin.editCategory');
            Route::post('/edit/{id}', 'update')->name('editCategory');

            // پنهان کردن دسته‌بندی
            Route::get('/hide/{id}', 'hide')->name('category.hide');

            // آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
            Route::get('/remove/{id}', 'remove')->name('category.remove');
            Route::get('/visible/{id}', 'visible')->name('category.visible');

            // نمایش اخبار مربوط به هر دسته‌بندی
            Route::get('/show/{name}', 'newsShow')->name('category.show');
        });            
    });

    // ادمین ها
    Route::controller(AdminManagementController::class)->group(function () {
        Route::group(['prefix' => 'admins'], function () {
            // لیست ادمین ها
            Route::get('/', 'list')->name('admin.list');

            // افزودن ادمین
            Route::get('/add', 'showAdminAdd')->name('admin.adminsAdd');
            Route::post('/add', 'add')->name('adminsAdd');
        });            
    });

    // کاربران
    Route::controller(AdminUserController::class)->group(function () {
        Route::group(['prefix' => 'users'], function () {
            // لیست کاربران ها
            Route::get('/', 'list')->name('admin.users');

            //  حذف کاربر
            Route::get('/remove/{id}', 'remove')->name('user.remove');

            // تبدیل کاربر عادی به ادمین
            Route::get('/make-admin/{id}', 'makeAdmin')->name('makeAdmin');
        });            
    });
});