<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * مدیریت اخبار توسط ادمین
 */
class AdminNewsController extends AdminController
{
    /**
     * صفحه‌ی عملیات مربوط به اخبار 
     */
    public function panel()
    {
        $news = News::with('categories')->get();
        return view('admin.news.dashboard', ['news' => $news]);
    }

    /**
     *نمایش صفحه‌ی اضافه کردن خبر
     */
    public function showNewsAdd()
    {
        $categories = Category::all();
        return view('admin.news.news_add', ['categories' => $categories]);
    }

    /**
     * دریافت اطلاعات خبر و پالایش اطلاعات و اضافه کردن خبر
     */
    public function add(CreateNewsRequest $request)
    {
        $newsDetails = collect($request->validated())->except(['image', 'categories'])->toArray();
        // ذخیره تصویر
        $fileName = Carbon::now()->getTimestamp().$request->image->getClientOriginalName();
        $destinationPath = public_path()."/images/news";
        $request->image->move($destinationPath, $fileName);

        // ذخیره اطلاعات در دیتابیس
        $newsDetails['image'] = "images/news/$fileName";
        $news = News::create($newsDetails);
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        // اضافه کردن دسته‌بندی ها
        if ($request->categories) {
            try {
                $news->categories()->attach($request->categories);
            }
            catch(\Exception $exception){
                return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        return redirect()->
            route('admin.dashboard')->
            with('message', 'خبر جدید با موفقیت اضافه شد ✅');
    }

    /**
     * نمایش صفحه‌ی ویرایش کردن یک خبر
     */
    public function showNewsEdit($id)
    {
        $news = News::findOrFail($id);

        //دسته‌بندی های نسبت داده شده به خبر
        $newsCategories = News::findOrFail($id)->categories;  

        // دسته‌بندی هایی که به خبر موردنظر تعلق ندارند
        $categoriesNotRelated = Category::whereDoesntHave('news', function ($query) use ($id) {
            $query->where('news_id', $id);
        })->get();
        
        return view('admin.news.news_edit', [
            'newsCategories' => $newsCategories, 
            'categoriesNotRelated' => $categoriesNotRelated, 
            'news' => $news
        ]);
    }

    /**
     * پالایش اطلاعات و ویرایش کردن یک خبر
     */
    public function edit(UpdateNewsRequest $request)
    {
        // چک کردن درست بودن آی‌دی
        $oldNews = News::findOrFail($request->id);

        // حذف فیلد های خالی
        $newsEdit = collect($request->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        // ذخیره کردن عکس در صورت وجود
        if ($request->image) {
            $fileName = Carbon::now()->getTimestamp().$request->image->getClientOriginalName();
            $destinationPath = public_path()."/images/news";
            $request->image->move($destinationPath, $fileName);
            $newsEdit['image'] = "images/news/".$fileName;
        }

        // اضافه کردن دسته‌بندی های جدید در صورن وجود
        if ($request->add_categories) {
            try {
                $oldNews->categories()->attach($request->add_categories);
            }
            catch(\Exception $exception){
                return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        // حذف دسته‌بندی های خبر در صورت وجود
        if ($request->delete_categories) {
            try {
                $oldNews->categories()->detach($request->delete_categories);
            }
            catch(\Exception $exception){
                return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        // ذخیره اطلاعات در دیتابیس
        $news = News::where('id', $request->id)->update($newsEdit);
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }
        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت ویرایش شد ✅');
    }

    /**
     *  حذف کامل خبر از دیتابیس
     */
    public function remove($id)
    {
        News::findOrFail($id);

        // خذف از دیتابیس
        $destroy = News::destroy($id);
        if (!$destroy) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت حذف شد ✅');
    }

    /**
     *  تغییر وضعیت خبر به عدم نمایش
     */
    public function hide($id)
    {
        // برسی وجود خبر
        $news = News::where(['id' => $id, 'status' => 1])->first();
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'خبر مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت به عدم نمایش
        $hide = News::where('id', $id)->update(['status' => 0]);
        if (!$hide) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت پنهان شد ✅');
    }

    /**
     * آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
     */
    public function visible($id)
    {
        $news = News::where(['id' => $id, 'status' => 0])->first();
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'خبر مورد نظر پیدا نشد ❗');
        }

        $visible = News::where('id', $id)->update(['status' => 1]);
        if (!$visible) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت آشکار شد ✅');
    }
}
