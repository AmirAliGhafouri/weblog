<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    /**
     * صفحه‌ی عملیات مربوط به دسته‌بندی ها 
     */
    public function adminCategory()
    {
        $categories = Category::all();
        return view('admin.categories.category', ['categories' => $categories]);
    }

    /**
     * نمایش صفحه‌ی اضافه کردن ‌دسته بندی
     */
    public function showCategoryAdd()
    {
        return view('admin.categories.category-add');
    }

    /**
     * اضافه کردن دسته‌بندی جدید
     */
    public function addCategory(CreateCategoryRequest $req)
    {
        // دریافت فیلد های تایید شده
        $request = collect($req->validated())->toArray();
        Category::create($request);
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی جدید با موفقیت اضافه شد ✅');
    }

    /**
     * نمایش صفحه ی ویرایش دسته‌بندی
     */
    public function showCategoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.category-edit', ['category' => $category]);
    }

    /**
     *  ویرایش دسته‌بندی
     */
    public function categoryEdit(UpdateCategoryRequest $req)
    {
        Category::findOrFail($req->id);

        // حذف فیلد های خالی
        $request = collect($req->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        Category::where('id', $req->id)->update($request);
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر با موفقیت ویرایش شد ✅');
    }

    /**
     * حذف دسته‌بندی از دیتابیس
     */
    public function categoryRemove($id)
    {
        category::findOrFail($id);
        // پاک کردن از دیتابیس

        Category::destroy($id);
        // واک کردن رکورد هایی که این کتگوری به خبری اختصاص داده شده بوند
        NewsCategory::where('category_id', $id)->delete();
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر با موفقیت حذف شد ✅');
    }

    /**
     * پنهان کردن یک دسته‌بندی
     */
    public function categoryHide($id)
    {
        // چک کردن وجود دسته‌بندی مورد نظر
        $category = Category::where(['id' => $id, 'status' => 0])->first();
        if ($category)
            return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر پیدا نشد ❗');

        // تغییر وضعیت به عدم نمایش
        Category::where('id', $id)->update(['status' => 0]);
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر با موفقیت پنهان شد ✅');
    }

    /**
     *  آشکار کردن یک دسته‌بندی پنهان
     */
    public function categoryVisible($id)
    {
        // چک کردن وجود دسته‌بندی مورد نظر
        $category = Category::where(['id' => $id, 'status' => 1])->first();
        if ($category)
            return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر پیدا نشد ❗');

        // تغییر وضعیت به آشکار
        Category::where('id', $id)->update(['status' => 1]);
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی موردنظر با موفقیت آشکار شد ✅');
    }

    /**
     * نمایش اخبار مربوط به دسته‌بندی ها حتی با وضعیت پنهان
     */
    public function categoryNewsShow($name)
    {
        // اخبار
        $categories = DB::table('news_categories')
            ->join('categories', 'news_categories.category_id', '=', 'categories.id')
            ->join('news', 'news_categories.news_id', '=', 'news.id')
            ->where(['categories.name' => $name, 'news.status' => 1])
            ->select('*', 'news.created_at as news_created_at')
            ->get();

        // ویژگی ها دسته‌بندی
        $categoryDetail = Category::where('name', $name)->first();
        return view('category', ['categories' => $categories, 'categoryDetail' => $categoryDetail]);
    }
}
