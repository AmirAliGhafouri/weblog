<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * 
     */
    public function newsDetails($newsId)
    {
        $newsDetail = News::findOrFail($newsId);
        $newsCategories = DB::table('news_categories')
            ->join('categories', 'news_categories.category_id', '=', 'categories.id')
            ->where(['news_id' => $newsId, 'categories.status' => 1])
            ->select('*')
            ->get();

        return view('details', ['newsDetails' => $newsDetail, 'newsCategories' => $newsCategories]);
    }
}
