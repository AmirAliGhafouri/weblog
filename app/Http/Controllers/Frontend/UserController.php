<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * اعمال مربوز به کاربران
 */
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
    public function panel()
    {
        $user_id = auth()->user()->id;
        // مشخصات کاربر
        $user = User::where('id', $user_id)->first();

        // فرستادن مشخصات کاربر به صفحه ی ویرایش
        return view('frontend.user', ['user' => $user]);
    }

    /**
     * ویرایش مشخصات کاربر
     */
    public function update(UpdateUserRequest $req)
    {
        $user_id = auth()->user()->id;
        // حذف فیلد های خالی
        $request = collect($req->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        // آپدیت کردن
        User::where('id', $user_id)->update($request);

        // برگشت به صفحه ی ویرایش با پیغام موفقیت
        return redirect()
            ->route('user.panel')
            ->with('message', 'ویرایش اطلاعات اب موفقیت انجام شد ✅');
    }

    /**
     * نوتفیکیشن های ارسال شده برای یک کاربر
     */
    public function notfications()
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
