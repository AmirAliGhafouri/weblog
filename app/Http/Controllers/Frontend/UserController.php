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

    /**
     * نوتفیکیشن های ارسال شده برای یک کاربر
     */
    public function user_notfications()
    {
        // مشخصات کاربر
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        // نوتفیکشین های خوانده نشده
        $notifications = $user->unReadNotifications;

        // تغییر وضعیت نوتفیکیشن ها به خوانده شده
        foreach ($notifications as $item) {
            $item->markAsRead();
        }

        // فرستادن نوتفیکشین های خوانده نشده به صفحه ی نوتفیکیشن کاربر
        return view('frontend.notifications', ['notifications' => $notifications]);
    }
}
