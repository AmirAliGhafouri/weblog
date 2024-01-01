<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * اعمال مربوط به اخبار
 */
class NewsController extends Controller
{
    /**
     * نمایش جزییات خبر و دسته‌بندی های متعلق به آن
     * افزایش تعداد بازدید خبر
     */
    public function details($newsId)
    {
        // دریافت اطلاعات یک خبر
        $newsDetail = News::findOrFail($newsId);

        // دریافت دسته‌بندی های فعال یک خبر
        $newsCategories = $newsDetail->categories->where('status', 1);

        // اضافه کردن تعداد بازدید خبر
        $filePath = public_path('json/counter.json');

        // وجود داشه باشه آپدیت می‌شود  json اگر فایل
        if (File::exists($filePath)) {
            // محتویات فایل
            $fileData = json_decode(File::get($filePath), true);

            // اگر آی‌دی خبر مورد نظر وجود نداشت اضافه می شود
            if (!isset($fileData[$newsId])) {

                // آی‌دی خبر مورد نظر رو در فایل جیسون ذخیره می شود
                $this->addValueToJson($newsId, $filePath);

                // برگردوندن اطلاعات خبر و دسته‌بندی هایش وتعداد بازدید به صفحه ی جزییات خبر
                return view('frontend.details', [
                    'newsDetails' => $newsDetail, 
                    'viewCount' => 1, 
                    'newsCategories' => $newsCategories
                ]);
            }
            
            // تعداد بازدید خبر مورد‌نظر آپدیت می‌شود  
            $this->updateValueInJason($newsId, $fileData, $filePath);

            // تعداد بازدید حال حاضر خبر
            $viewCount = $this->showViewCount($newsId);

            // برگردوندن اطلاعات خبر و دسته‌بندی هایش وتعداد بازدید به صفحه ی جزییات خبر
            return view('frontend.details', [
                'newsDetails' => $newsDetail, 
                'viewCount' => $viewCount, 
                'newsCategories' => $newsCategories
            ]);
        }

        // فایل جیسون که از قبل وجود ندارد ساخته می‌شود و آی‌دی خبر موردنظر در آن ذخیره می‌شود
        $this->createJson($newsId, $filePath);

        // برگردوندن اطلاعات خبر و دسته‌بندی هایش وتعداد بازدید به صفحه ی جزییات خبر
        return view('frontend.details', [
            'newsDetails' => $newsDetail, 
            'viewCount' => 1, 
            'newsCategories' => $newsCategories
        ]);
    }

    /**
     * json اضافه کردن یک مقدار جدید به فایل
     */
    public function addValueToJson($newsId, $filePath)
    {
        // مقدار جدید
        $fileData[$newsId] = 1;

        // json تبدیل به فرمت
        $jsonNewData = json_encode($fileData, JSON_PRETTY_PRINT);

        // ذخیره در فایل
        File::put($filePath, $jsonNewData);
    }

    /**
     * آپدیت کردن یک مقدار موجود در فایل جیسون
     */
    public function updateValueInJason($newsId, $fileData, $filePath)
    {
        // مقدار موجود را آپدیت می کنیم
        $addView = [$newsId => $fileData[$newsId] + 1];
        $newData[$newsId] = $addView[$newsId];

        // json تبدیل مقدار جدید به فرمت
        $jsonNewData = json_encode($newData, JSON_PRETTY_PRINT);

        // ذخیره در فایل
        File::put($filePath, $jsonNewData);
    }

    /**
     * ساختن یک فایل جیسون و ذخیره بازدید خبر مورد نظر 
     */
    public function createJson($newsId, $filePath)
    {
        // مورد نظر یکی ایجاد می کنیم json در صورت وجود نداشتن فایل
        $data = [$newsId => 1];

        // json تبدیل مقدار جدید به فرمت
        $jsonNewData = json_encode($data, JSON_PRETTY_PRINT);

        File::ensureDirectoryExists(dirname($filePath));
        // ذخیره فایل
        File::put($filePath, $jsonNewData);
    }

    /**
     * ajax با json خواندن تعداد بازدید یک خبر از روی فایل
     */
    public function showViewCount($newsId)
    {
        $filePath = 'json/counter.json';

        // محتویات فایل جیسون
        $fileDataJson = File::get($filePath);
        $fileData = json_decode($fileDataJson, true);

        // تعداد بازدید خبر مورد‌نظر
        return $fileData[$newsId];
    }

}
