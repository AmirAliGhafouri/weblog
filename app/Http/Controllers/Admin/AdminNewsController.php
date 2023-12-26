<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
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
     *نمایش صفحه‌ی اضافه کردن خبر
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
        $fileName = $req->image->getClientOriginalName();
        $dstPath = public_path()."/images/news";
        $req->image->move($dstPath, $fileName);

        // ذخیره اطلاعات در دیتابیس
        $request['image'] = "images/news/$fileName";
        News::create($request);
        return redirect()->route('admin.dashboard')->with('message', 'خبر جدید با موفقیت اضافه شد ✅');
    }

    /**
     * نمایش صفحه‌ی ویرایش کردن یک خبر
     */
    public function showNewsEdit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();
        return view('admin.news.news-edit', ['categories' => $categories, 'news' => $news]);
    }

    /**
     * ویرایش کردن یک خبر
     */
    public function newsEdit(UpdateNewsRequest $req)
    {
        // چک کردم درست بودن آی‌دی
        News::findOrFail($req->id);
        $request = collect($req->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        // ذخیره کردن عکس در صورت وجود
        if ($req->image) {
            $fileName = Carbon::now()->getTimestamp().$req->image->getClientOriginalName();
            $dstPath = public_path()."/images/news";
            $req->image->move($dstPath, $fileName);
            $request['image'] = "images/news/".$fileName;
        }

        // ذخیره اطلاعات در دیتابیس
        News::where('id', $req->id)->update($request);
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت ویرایش شد ✅');
    }

    /**
     *  حذف کامل خبر از دیتابیس
     */
    public function newsRemove($id)
    {
        News::findOrFail($id);
        News::destroy($id);
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت حذف شد ✅');
    }

    /**
     *  تغییر وضعیت خبر به عدم نمایش
     */
    public function newsHide($id)
    {
        News::findOrFail($id);
        News::where('id', $id)->update(['status' => 0]);
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت پنهان شد ✅');
    }
}
