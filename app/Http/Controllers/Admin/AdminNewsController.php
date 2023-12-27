<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\NewsCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminNewsController extends Controller
{
    /**
     * صفحه‌ی عملیات مربوط به اخبار 
     */
    public function adminPanel()
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
        return view('admin.news.news-add', ['categories' => $categories]);
    }

    /**
     * اضافه کردن خبر
     */
    public function newsAdd(CreateNewsRequest $req)
    {
        $request = collect($req->validated())->except(['image', 'categories'])->toArray();
        // ذخیره تصویر
        $fileName = $req->image->getClientOriginalName();
        $dstPath = public_path()."/images/news";
        $req->image->move($dstPath, $fileName);

        // ذخیره اطلاعات در دیتابیس
        $request['image'] = "images/news/$fileName";
        $news = News::create($request);

        // اضافه کردن دسته‌بندی ها
        foreach ($req->categories as $category_id) {
            NewsCategory::create([
                'news_id' => $news->id,
                'category_id' => $category_id
            ]);
        }

        return redirect()->route('admin.dashboard')->with('message', 'خبر جدید با موفقیت اضافه شد ✅');
    }

    /**
     * نمایش صفحه‌ی ویرایش کردن یک خبر
     */
    public function showNewsEdit($id)
    {
        $news = News::findOrFail($id);
        //دسته‌بندی های نسبت داده شده به خبر
        $newsCategories = DB::table('news_categories')
            ->join('categories', 'news_categories.category_id', '=', 'categories.id')
            ->where('news_id', $id)
            ->select('*', 'news_categories.id as news_categories_id', 'categories.id as id')
            ->get();

        // آی‌دی های دسته‌بندی هایی که به خبر نسبت داده شدن
        $newsCategoriesId = [];
        foreach ($newsCategories as $item) {
            array_push($newsCategoriesId, $item->id);
        }

        // آی‌دی دسته‌بندی هایی که به خبر نسبت داده نشده اند 
        $allCategoriesId = Category::select('id')->get();
        $CategoriesIdArray = [];
        foreach ($allCategoriesId as $item) {
            array_push($CategoriesIdArray, $item->id);
        }

        $otherCategoriesId = array_values(array_diff($CategoriesIdArray, $newsCategoriesId));

        // دسته‌بندی هایی که به خبر نسبت داده نشده اند
        $otherCategories = [];
        foreach ($otherCategoriesId as $item) {
            array_push($otherCategories, Category::where('id', $item)->first());
        }
        
        return view('admin.news.news-edit', ['newsCategories' => $newsCategories, 'otherCategories' => $otherCategories, 'news' => $news]);
    }

    /**
     * ویرایش کردن یک خبر
     */
    public function newsEdit(UpdateNewsRequest $req)
    {
        // چک کردن درست بودن آی‌دی
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

        if ($req->add_categories) {
            foreach ($req->add_categories as $item) {
                NewsCategory::create([
                    'news_id' => $req->id,
                    'category_id' => $item
                ]);
            }
        }

        if ($req->delete_categories) {
            foreach ($req->delete_categories as $item) {
                NewsCategory::where(['news_id' => $req->id, 'category_id' => $item])->delete();
            }
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
        NewsCategory::where('news_id', $id)->delete();
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت حذف شد ✅');
    }

    /**
     *  تغییر وضعیت خبر به عدم نمایش
     */
    public function newsHide($id)
    {
        $news = News::where(['id' => $id, 'status' => 1])->first();
        if (!$news)
            return redirect()->route('admin.dashboard')->with('message', 'خبر مورد نظر پیدا نشد ❗');
        News::where('id', $id)->update(['status' => 0]);
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت پنهان شد ✅');
    }

    /**
     * آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
     */
    public function newsVisible($id)
    {
        $news = News::where(['id' => $id, 'status' => 0])->first();
        if (!$news)
            return redirect()->route('admin.dashboard')->with('message', 'خبر مورد نظر پیدا نشد ❗');
        News::where('id', $id)->update(['status' => 1]);
        return redirect()->route('admin.dashboard')->with('message', 'خبر موردنظر با موفقیت آشکار شد ✅');
    }
}
