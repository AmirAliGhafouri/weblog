<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

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
     * اضافه کردن دشته‌بندی جدید
     */
    public function addCategory(CreateCategoryRequest $req)
    {
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
        $request = collect($req->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        Category::where('id', $req->id)->update($request);
        return redirect()->route('admin.category')->with('message', 'دسته‌بندی مورد نظر با موفقیت ویرایش شد ✅');
    }
}
