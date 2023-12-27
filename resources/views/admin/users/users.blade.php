@extends('admin/master')

@section('content')
    @if(Session::has('message'))
    <div class="alert alert-warning alert-dismissible fade show position-absolute text-center w-100" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="px-3 bg-light w-100">
        <div class="w-100 py-4">
            <h1 class="text-center">مدیریت ادمین ها</h1>
        </div>

        <div>
            <table class="table table-hover text-center">
                <tr>
                    <th class="bg-title">نام</th>
                    <th class="bg-title">نام خانوادگی</th>
                    <th class="bg-title">ایمیل</th>
                    <th class="bg-title">شماره تلفن</th>
                    <th class="bg-title">نوع حساب</th>
                    <th class="bg-title">زمان عضویت</th>
                    <th class="bg-title">عملیات</th>
                </tr>

                @foreach($users as $item)
                    <tr>
                        <td>
                            {{ $item->first_name }}
                        </td>

                        <td>
                            {{ $item->last_name }}
                        </td>

                        <td>
                            {{ $item->email }}
                        </td>

                        <td>
                            {{ $item->phone_number }}
                        </td>

                        <td>
                            @if ($item->role)
                                {{ 'ادمین' }}
                            @else
                                {{ 'کاربر عادی' }}
                            @endif
                        </td>

                        <td>
                            {{ $item->created_at }}
                        </td>

                        <td>
                            @if (!$item->role)
                                <a href="{{ route('details', ['id' => $item->id]) }}">
                                    <button class="btn btn-main">تغییر به ادمین <i class="fa-solid fa-user"></i></button>
                                </a>

                                <!-- ویرایش خبر -->
                                <a href="{{ route('user.remove', ['id' => $item->id]) }}">
                                    <button class="btn btn-danger">حذف <i class="fa-solid fa-trash"></i></button>
                                </a>
                            @else
                                <p>--------</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection