<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 *  مدیریت ادمین توسط ادمین
 */
class AdminAdminController extends AdminController
{
    /**
     * لیست همه‌ی ادمین ها
     */
    public function list()
    {
        $admins = User::where('role', 1)->get();
        return view('admin.admin.admins', ['admins' => $admins]);
    }

    /**
     *  نمایش صفحه ی افزودن ادمین جدید
     */
    public function showAdminAdd()
    {
        return view('admin.admin.admin_add');
    }

    /**
     *  افزودن ادمین جدید
     */
    public function add(CreateAdminRequest $request)
    {
        $newAdmin = collect($request->validated())->toArray();
        $newAdmin['role'] = 1;

        // افزودن ادمین
        $admin = User::create($newAdmin);
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
