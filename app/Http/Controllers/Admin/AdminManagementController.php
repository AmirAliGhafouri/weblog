<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 *  مدیریت ادمین توسط ادمین
 */
class AdminManagementController extends AdminController
{
    /**
     * لیست همه‌ی ادمین ها
     */
    public function list()
    {
        // ادمین ها
        $admins = User::where('role', 1)->get();
        return view('admin.admin.admins', ['admins' => $admins]);
    }

    /**
     *  نمایش صفحه ی افزودن ادمین جدید
     */
    public function add()
    {
        return view('admin.admin.admin_add');
    }

    /**
     *  افزودن ادمین جدید
     */
    public function create(CreateAdminRequest $request)
    {
        // اطلاعات دریافت و پالایش شده
        $newAdmin = collect($request->validated())->toArray();
        $newAdmin['role'] = 1;

        // افزودن ادمین
        $admin = User::create($newAdmin);

        // ذخیره نشدن اطلاعات ادمین جدید در دیتابیس 
        if (!$admin) {
            return redirect()
                ->route('admin.list')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }
        
        return redirect()
            ->route('admin.list')
            ->with('message', 'ادمین جدید با موفقیت اضافه شد ✅');
    }
}
