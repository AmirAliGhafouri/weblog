@extends('layouts.admin.master')

@section('content')
    @if(Session::has('message'))
    <div class="alert alert-warning alert-dismissible fade show position-absolute text-center w-100" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="px-3 bg-light w-100">
        <div class="w-100 py-4">
            <h1 class="text-center">مدیریت دسته‌بندی ها</h1>
        </div>

        <div class="my-3">
            <a href="{{ route('admin.categoryAdd') }}" class="btn btn-title">افزودن دسته‌بندی جدید <i class="fa-solid fa-circle-plus"></i></a>
        </div>

        <div>
            <table class="table table-hover text-center">
                <tr>
                    <th class="bg-title">عنوان</th>
                    <th class="bg-title">توضیحات</th>
                    <th class="bg-title">وضعیت دسته‌بندی</th>
                    <th class="bg-title">عملیات</th>
                </tr>

                @foreach($categories as $item)
                    <tr>
                        <td>
                            {{ $item->name }}
                        </td>

                        <td class="table-description text-justify">
                            @if ($item->description)
                                {{ $item->description }}
                            @else
                                <p class="text-center">---------</p>
                            @endif    
                        </td>

                        <td>
                            @if ($item->status)
                                آشکار ✅
                            @else
                                عدم نمایش ❌
                            @endif
                        </td>

                        <td>
                            <!-- مشاهده‌ی خبر های این دسته‌بندی -->
                            <a href="{{ route('category.show', ['name' => $item->name]) }}">
                                <button class="btn btn-main">مشاهده <i class="fa-regular fa-folder-open"></i></button>
                            </a>

                            <!-- ویرایش دسته‌بندی -->
                            <a href="{{ route('admin.editCategory', ['id' => $item->id]) }}">
                                <button class="btn btn-primary">ویرایش <i class="fa-solid fa-pen-to-square"></i></button>
                            </a>

                            @if ($item->status)
                                <!-- حذف دسته‌بندی -->
                                <div class="dropdown d-inline">
                                    <button class="btn btn-danger dropdown-toggle px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        حذف <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <!-- حذف از دیتابیس -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('news.remove', ['id' => $item->id]) }}">حذف کامل <i class="fa-solid fa-trash"></i></a>
                                        </li>

                                        <!-- تغییر وضعیت به عدم نمایش -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('category.hide', ['id' => $item->id]) }}">عدم نمایش <i class="fa-solid fa-eye-slash"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('category.visible', ['id' => $item->id]) }}">
                                    <button class="btn btn-success">آشکار کردن <i class="fa-solid fa-eye"></i></button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection