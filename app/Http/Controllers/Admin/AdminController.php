<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 *  مدیریت ادمین توسط ادمین
 */
class AdminController extends Controller
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
    public function add(CreateAdminRequest $req)
    {
        $request = collect($req->validated())->toArray();
        $request['role'] = 1;

        // افزودن ادمین
        $admin = User::create($request);
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
