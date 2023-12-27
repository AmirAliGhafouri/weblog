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
}
