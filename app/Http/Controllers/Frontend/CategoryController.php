<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * اعمال مربوط به دسته‌بندی ها
 */
class CategoryController extends Controller
{
    /**
     *  نمایش اخبار بر اساس دسته‌بندی که نامش دریافت شده
     */
    public function categoryNewsShow($name)
    {
        // اخبار
        $newsInCategory = News::whereHas('categories', function ($query) use ($name) {
            $query->where(['name' => $name, 'status' => 1]);
        })->get();  

        // مشخصات دسته‌بندی
        $categoryDetail = Category::where(['name' => $name, 'status' => 1])->first();

        // ارسال جزییات دسته‌بندی و اخبار مربوط بهش
        return view('frontend.category', [
            'categories' => $newsInCategory, 
            'categoryDetail' => $categoryDetail
        ]);
    }
}
