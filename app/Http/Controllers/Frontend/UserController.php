<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * برسی اینکه آیا کاربر وارد حساب خود شده یا نه
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * نشان دادن مشخصات 
     * فرم تغییر مشخصات    
     */
    public function showUserPanel()
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        return view('frontend.user', ['user' => $user]);
    }

    /**
     * ویرایش مشخصات کاربر
     */
    public function edit(UpdateUserRequest $req)
    {
        $user_id = auth()->user()->id;
        $request = collect($req->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        User::where('id', $user_id)->update($request);
        return redirect()->route('user.panel')->with('message', 'ویرایش اطلاعات اب موفقیت انجام شد ✅');

    }
}
