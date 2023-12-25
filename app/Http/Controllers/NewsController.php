<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * 
     */
    public function newsDetails($newsId)
    {
        $newsDetail = News::findOrFail($newsId);
        return view('details', ['newsDetails' => $newsDetail]);
    }
}
