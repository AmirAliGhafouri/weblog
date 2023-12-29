<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $news = News::with(['categories' => function ($query) {
            $query->where('status', 1);
        }])
        ->where('status', 1)
        ->get();
        return view('frontend.home', ['news' => $news]);
    }
}
