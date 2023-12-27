<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * صفحه‌ی اصلی مدیریت کاربران
     */
    public function usersList()
    {
        $users = User::all();
        return view('admin.users.users', ['users' => $users]);
    }

    /**
     * حذف کردن یک کاربر
     */
    public function userRemove($id)
    {
        $user = User::where(['id' => $id, 'role' => 0])->first();
        if (!$user)
            return redirect()->route('admin.users')->with('message', 'کاربر مورد نظر پیدا نشد ❗');
        $user->delete();
        return redirect()->route('admin.users')->with('message', 'کاربر مورد نظر با موفقیت حذف شد ✅');
    }

    /**
     * تبدیل کاربر عادی به ادمین
     */
    public function makeAdmin($id)
    {
        $user = User::where(['id' => $id, 'role' => 0]);
        if (!$user)
            return redirect()->route('admin.users')->with('message', 'کاربر مورد نظر پیدا نشد ❗');
        $user->update(['role' => 1]);
        return redirect()->route('admin.users')->with('message', 'کاربر مورد نظر با موفقیت به ادمین تبدیل شد ✅');


    }
}
