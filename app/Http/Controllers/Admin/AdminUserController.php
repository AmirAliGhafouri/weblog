<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * مدیریت کاربران توسط ادمین
 */
class AdminUserController extends AdminController
{
    /**
     * صفحه‌ی اصلی مدیریت کاربران
     */
    public function list()
    {
        // همه‌ی کاربران
        $users = User::paginate(10);
        return view('admin.user.users', ['users' => $users]);
    }

    /**
     * حذف کردن یک کاربر
     */
    public function remove($id)
    {
        // برسی وجود کاربر
        $user = User::where(['id' => $id, 'role' => 0])->first();
        if (!$user) {
            return redirect()
                ->route('admin.users')
                ->with('message', 'کاربر مورد نظر پیدا نشد ❗');
        }

        // حذف کاربر از دیتابیس
        $destroy = User::destroy($id);

        // عدم موفقیت
        if (!$destroy) {
            return redirect()
                ->route('admin.users')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.users')
            ->with('message', 'کاربر مورد نظر با موفقیت حذف شد ✅');
    }

    /**
     * تبدیل کاربر عادی به ادمین
     */
    public function makeAdmin($id)
    {
        // برسی وجود کاربر و ادمین نبودنش
        $user = User::where(['id' => $id, 'role' => 0]);
        if (!$user) {
            return redirect()
                ->route('admin.users')
                ->with('message', 'کاربر مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت به ادمین
        $userUpdate = $user->update(['role' => 1]);

        // عدم موفقیت
        if (!$userUpdate) {
            return redirect()
                ->route('admin.users')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }
        return redirect()
            ->route('admin.users')
            ->with('message', 'کاربر مورد نظر با موفقیت به ادمین تبدیل شد ✅');
    }
}
