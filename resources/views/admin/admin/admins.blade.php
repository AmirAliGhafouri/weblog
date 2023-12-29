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
            <h1 class="text-center">مدیریت ادمین ها</h1>
        </div>

        <div class="my-3">
            <a href="{{ route('admin.adminsAdd') }}" class="btn btn-title">افزودن ادمین جدید <i class="fa-solid fa-circle-plus"></i></a>
        </div>

        <div>
            <table class="table table-hover text-center">
                <tr>
                    <th class="bg-title">نام</th>
                    <th class="bg-title">نام خانوادگی</th>
                    <th class="bg-title">ایمیل</th>
                    <th class="bg-title">شماره تلفن</th>
                    <th class="bg-title">زمان عضویت</th>
                </tr>

                @foreach($admins as $item)
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
                            {{ $item->created_at }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection