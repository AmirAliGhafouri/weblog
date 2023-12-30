<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

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
        return $this->belongsToMany(Category::class, 'category_news', 'news_id', 'category_id');
    }

    protected $dates = ['created_at', 'updated_at'];

    public function getCreatedAtAttribute($value)
    {
        return Jalalian::fromDateTime($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Jalalian::fromDateTime($value)->format('Y-m-d H:i:s');
    }
 }
