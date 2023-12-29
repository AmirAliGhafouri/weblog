<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     *  نمایش اخبار بر اساس دسته بندی
     */
    public function categoryNewsShow($name)
    {
        $categories = DB::table('news_categories')
            ->join('categories', 'news_categories.category_id', '=', 'categories.id')
            ->join('news', 'news_categories.news_id', '=', 'news.id')
            ->where(['categories.name' => $name, 'news.status' => 1, 'categories.status' => 1])
            ->select('*', 'news.created_at as news_created_at')
            ->get();

        $categoryDetail = Category::where(['name' => $name, 'status' => 1])->first();
        return view('frontend.category', ['categories' => $categories, 'categoryDetail' => $categoryDetail]);
    }
}
