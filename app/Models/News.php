<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = "news";
    protected $fillable = [
        'title', 
        'short_text', 
        'long_text', 
        'image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'news_categories', 'news_id', 'category_id');
    }
 }
