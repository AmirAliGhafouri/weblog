<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CreateNewsEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

/**
 * اعمال مربوط به صفحه ی اصلی
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * صفحه ی اصلی سایت
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // تمام اخبار فعال با دسته‌بندی هاشون
        $news = News::with(['categories' => function ($query) {
            $query->where('status', 1);
        }])
        ->where('status', 1)
        ->get();

        // فرستادن اخبار و دسته‌بندی ها به صفحه ی اصلی
        return view('frontend.home', ['news' => $news]);
    }
}
