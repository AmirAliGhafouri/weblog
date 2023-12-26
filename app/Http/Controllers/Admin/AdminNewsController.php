<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class AdminNewsController extends Controller
{
    /**
     * صفحه‌ی عملیات مربوط به اخبار 
     */
    public function adminPanel()
    {
        $news = News::all();
        return view('admin.news.dashboard', ['news' => $news]);
    }

    /**
     * صفحه‌ی اضافه کردن خبر
     */
    public function showNewsAdd()
    {
        $categories = Category::all();
        return view('admin.news.news-add', ['categories' => $categories]);
    }

    /**
     * اضافه کردن خبر
     */
    public function newsAdd(CreateNewsRequest $req)
    {
        $request = collect($req->validated())->except('image')->toArray();
        // ذخیره تصویر
        $fileName= $req->image->getClientOriginalName();
        $dstPath=public_path()."/images/news";
        $req->image->move($dstPath, $fileName);

        // ذخیره اطلاعات در دیتابیس
        $request['image'] = "images/news/$fileName";
        News::create($request);
        return redirect()->route('admin.dashboard')->with('message', 'خبر جدید با موفقیت اضافه شد ✅');
    }

    /**
     * ویرایش کردن یک خبر
     */
    public function showNewsEdit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();
        return view('admin.news.news-edit', ['categories' => $categories, 'news' => $news]);
    }
}
