<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * 
     */
    public function details($newsId)
    {
        $newsDetail = News::findOrFail($newsId);
        $newsCategories = DB::table('news_categories')
            ->join('categories', 'news_categories.category_id', '=', 'categories.id')
            ->where(['news_id' => $newsId, 'categories.status' => 1])
            ->select('*')
            ->get();

        return view('frontend.details', ['newsDetails' => $newsDetail, 'newsCategories' => $newsCategories]);
    }
}
