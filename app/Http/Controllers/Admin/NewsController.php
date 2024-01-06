<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreateNews;
use App\Exceptions\DatabaseOperationException;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Jobs\NotificationJob;
use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

/**
 * مدیریت اخبار توسط ادمین
 */
class NewsController extends AdminController
{
    /**
     * صفحه‌ی عملیات مربوط به اخبار 
     * 
     * @return \Illuminate\Contracts\View\View نمایش صفحه‌ی لیست اخبار
     */
    public function index()
    {
        $news = News::with('categories')->paginate(5);

        return view('admin.news.dashboard', ['news' => $news]);
    }

    /**
     * نمایش صفحه‌ی اضافه کردن خبر 
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function add()
    {
        $categories = Category::all();

        // فرستادن دسته‌بندی ها به صفحه‌ی افزودن خبر
        return view('admin.news.news_add', ['categories' => $categories]);
    }

    /**
     * دریافت اطلاعات خبر و پالایش اطلاعات و اضافه کردن خبر
     * 
     * @param \App\Http\Requests\CreateNewsRequest $request مشخصات خبری که باید ایجاد بشه
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateNewsRequest $request)
    {
        $newsDetails = collect($request->validated())->except(['image', 'categories'])->toArray();
        // ذخیره تصویر
        $fileName = Carbon::now()->getTimestamp() . $request->image->getClientOriginalName();
        $destinationPath = public_path() . "/images/news";
        $request->image->move($destinationPath, $fileName);

        // ذخیره خبر در دیتابیس
        $newsDetails['image'] = "images/news/$fileName";
        $news = News::create($newsDetails);
        if (!$news) {
            throw new DatabaseOperationException('DATABASE_ERROR');
        }

        // اضافه کردن دسته‌بندی ها
        if ($request->categories) {
            try {
                $news->categories()->attach($request->categories);
            } catch (\Exception $exception) {
                return redirect()
                    ->route('admin.dashboard')
                    ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        // تعریف کردن یک رویداد برای فرستادن خبر ایجاد شده به کاربران عادی
        $users = User::where('role', 0)->get();
        event(new CreateNews($news, $users));

        // برای ارسال یک نوتیفیکیشن ایمیل برای ادمین ها 1 دقیقه بعد ایجاد خبر جدید job تشکیل یک
        $admin = User::findOrFail(7);
        NotificationJob::dispatch($news, $admin)
            ->onQueue('email')
            ->delay(now()->addMinute(1));

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر جدید با موفقیت اضافه شد ✅');
    }

    /**
     * نمایش صفحه‌ی ویرایش کردن یک خبر
     * 
     * @param int $id آی‌دی خبر
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);

        //دسته‌بندی های نسبت داده شده به خبر
        $newsCategories = News::findOrFail($id)->categories;

        // دسته‌بندی هایی که به خبر موردنظر تعلق ندارند
        $categoriesNotRelated = Category::whereDoesntHave('news', function ($query) use ($id) {
            $query->where('news_id', $id);
        })->get();

        return view('admin.news.news_edit', [
            'newsCategories' => $newsCategories,
            'categoriesNotRelated' => $categoriesNotRelated,
            'news' => $news
        ]);
    }

    /**
     * پالایش اطلاعات و ویرایش کردن یک خبر
     * 
     * @param \App\Http\Requests\UpdateNewsRequest $request مشخصات خبری که باید آپدیت بشه
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateNewsRequest $request)
    {
        // چک کردن درست بودن آی‌دی
        $oldNews = News::findOrFail($request->id);

        // حذف فیلد های خالی
        $newsEdit = collect($request->validated())->filter(function ($item) {
            return $item != null;
        })->toArray();

        // ذخیره کردن عکس در صورت وجود
        if ($request->image) {
            $fileName = Carbon::now()
                ->getTimestamp()
                . $request->image->getClientOriginalName();
            $destinationPath = public_path() . "/images/news";
            $request->image->move($destinationPath, $fileName);
            $newsEdit['image'] = "images/news/" . $fileName;
        }

        // اضافه کردن دسته‌بندی های جدید در صورن وجود
        if ($request->add_categories) {
            try {
                $oldNews->categories()->attach($request->add_categories);
            } catch (\Exception $exception) {
                return redirect()
                    ->route('admin.dashboard')
                    ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        // حذف دسته‌بندی های خبر در صورت وجود
        if ($request->delete_categories) {
            try {
                $oldNews->categories()->detach($request->delete_categories);
            } catch (\Exception $exception) {
                return redirect()
                    ->route('admin.dashboard')
                    ->with('message', 'عملیات موفقیت آمیز نبود ❗');
            }
        }

        // ذخیره اطلاعات در دیتابیس
        $news = News::where('id', $request->id)->update($newsEdit);

        // عدم موفقیت
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }
        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت ویرایش شد ✅');
    }

    /**
     *  حذف کامل خبر از دیتابیس
     * 
     * @param int $id آی‌دی خبری که قرار است حذف شود
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        News::findOrFail($id);

        $destroy = News::destroy($id);

        // عدم موفقیت
        if (!$destroy) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت حذف شد ✅');
    }

    /**
     *  تغییر وضعیت خبر به عدم نمایش
     * 
     * @param int $id آی‌دی خبری که قرار است پنهان شود
     * @return \Illuminate\Http\RedirectResponse
     */
    public function hide($id)
    {
        // برسی وجود خبر
        $news = News::where(['id' => $id, 'status' => 1])->first();
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'خبر مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت به عدم نمایش
        $hide = News::where('id', $id)->update(['status' => 0]);

        // عدم موفقیت
        if (!$hide) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت پنهان شد ✅');
    }

    /**
     * آشکار کردن خبر هایی که وضعیتشون عدم نمایش است
     * 
     * @param int $id آی‌دی خبری که قرار است آشکار شود
     * @return \Illuminate\Http\RedirectResponse
     */
    public function visible($id)
    {
        // برسی وجود خبر موردنظر
        $news = News::where(['id' => $id, 'status' => 0])->first();
        if (!$news) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'خبر مورد نظر پیدا نشد ❗');
        }

        // تغییر وضعیت خبر به آشکار
        $visible = News::where('id', $id)->update(['status' => 1]);

        // عدم موفقیت
        if (!$visible) {
            return redirect()
                ->route('admin.dashboard')
                ->with('message', 'عملیات موفقیت آمیز نبود ❗');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('message', 'خبر موردنظر با موفقیت آشکار شد ✅');
    }
}
