<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

/**
 * مدیریت دسته‌بندی ها توسط ادمین
 */
class CategoryController extends AdminController
{
    /**
     * صفحه‌ی عملیات مربوط به دسته‌بندی ها 
     */
    public function category()
    {
        // تمامی دسته‌بندی ها
        $categories = Category::paginate(5);
        return view('admin.category.category', ['categories' => $categories]);
    }

    /**
     * نمایش صفحه‌ی اضافه کردن ‌دسته بندی
     */
    public function showCategoryAdd()
    {
        return view('admin.category.category_add');
    }

    /**
     * دریافت مشخصات دسته‌بندی و اضافه کردن دسته‌بندی جدید
     */
    public function add(CreateCategoryRequest $request)
    {
        // ذخیره کردن دسته‌بندی جدید در دیتابیس
        $newCategory = Category::create($request->validated());

        // ذخیره نشدن دسته‌بندی دید در دیتابیس
        if (!$newCategory) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.category')
            ->with('message', 'دسته‌بندی جدید با موفقیت اضافه شد ✅');
    }

    /**
     * دریافت مشخصه دسته‌بندی و نمایش صفحه ی ویرایش دسته‌بندی به همراه مشخصات حال حاضر دسته‌بندی
     */
    public function showCategoryEdit($id)
    {
        // مشخصات دسته‌بندی
        $category = Category::findOrFail($id);
        return view('admin.category.category_edit', ['category' => $category]);
    }

    /**
     * دریافت مشخصات جدید دسته‌بندی و ویرایش دسته‌بندی
     */
    public function edit(UpdateCategoryRequest $request)
    {
        // چک کردن موجود بودن شناسه‌ی وارد شده
        Category::findOrFail($request->id);

        // حذف فیلد های خالی
        $categoryDetails = collect($request->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        $categorytEdit = Category::where('id', $request->id)->update($categoryDetails);

        // چک کردن موفقیت آمیز بودن عملیات
        if (!$categorytEdit) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }
        return redirect()
            ->route('admin.category')
            ->with('message', 'دسته‌بندی مورد نظر با موفقیت ویرایش شد ✅');
    }

    /**
     * حذف دسته‌بندی از دیتابیس
     */
    public function remove($id)
    {
        // چک کردن موجود بودن شناسه‌ی وارد شده
        category::findOrFail($id);

        // پاک کردن از دیتابیس
        $destroy = Category::destroy($id);
        if (!$destroy) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.category')
            ->with('message', 'دسته‌بندی مورد نظر با موفقیت حذف شد ✅');
    }

    /**
     * پنهان کردن یک دسته‌بندی
     */
    public function hide($id)
    {
        // چک کردن وجود دسته‌بندی مورد نظر
        $category = Category::where(['id' => $id, 'status' => 0])->first();
        if ($category) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'دسته‌بندی مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت به عدم نمایش
        $hide = Category::where('id', $id)->update(['status' => 0]);

        // عدم موفقیت
        if (!$hide) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.category')
            ->with('message', 'دسته‌بندی مورد نظر با موفقیت پنهان شد ✅');
    }

    /**
     *  آشکار کردن یک دسته‌بندی پنهان
     */
    public function visible($id)
    {
        // چک کردن وجود دسته‌بندی مورد نظر
        $category = Category::where(['id' => $id, 'status' => 1])->first();
        if ($category) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'دسته‌بندی مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت به آشکار
        $visible = Category::where('id', $id)->update(['status' => 1]);

        // عدم موفقیت
        if (!$visible) {
            return redirect()
                ->route('admin.category')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.category')
            ->with('message', 'دسته‌بندی موردنظر با موفقیت آشکار شد ✅');
    }

    /**
     * نمایش اخبار مربوط به دسته‌بندی ها حتی با وضعیت پنهان
     */
    public function newsShow($name)
    {
        // اخبار
        $newsInCategory = News::whereHas('categories', function ($query) use ($name) {
            $query->where('name', $name);
        })->get();

        // ویژگی ها دسته‌بندی
        $categoryDetail = Category::where('name', $name)->first();
        return view('frontend.category', [
            'categories' => $newsInCategory, 
            'categoryDetail' => $categoryDetail
        ]);
    }
}
