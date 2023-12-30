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
        $newsCategories = $newsDetail->categories->where('status', 1);

        return view('frontend.details', [
            'newsDetails' => $newsDetail, 
            'newsCategories' => $newsCategories
        ]);
    }
}
