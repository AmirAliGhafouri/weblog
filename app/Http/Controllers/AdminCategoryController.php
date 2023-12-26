<?php

namespace App\Http\Controllers;

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
}
