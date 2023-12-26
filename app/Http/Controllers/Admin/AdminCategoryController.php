<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
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
    public function showAddCategory()
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
}
