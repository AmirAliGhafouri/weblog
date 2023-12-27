<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * لیست همه‌ی ادمین ها
     */
    public function adminList()
    {
        $admins = User::where('role', 1)->get();
        return view('admin.admins.admins', ['admins' => $admins]);
    }

    /**
     *  نمایش صفحه ی افزودن ادمین جدید
     */
    public function showAdminAdd()
    {
        return view('admin.admins.admin-add');
    }

    /**
     *  افزودن ادمین جدید
     */
    public function adminAdd(CreateAdminRequest $req)
    {
        $request = collect($req->validated())->toArray();
        $request['role'] = 1;
        User::create($request);
        return redirect()->route('admin.list')->with('message', 'ادمین جدید با موفقیت اضافه شد ✅');
    }
}
