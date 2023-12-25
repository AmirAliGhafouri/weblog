@extends('master')

@section('content')
    <!-- نوار زیر هدر -->
    <div class="topbar m-0">
        <div class="py-5">
            <h1 class="text-center py-5">به این وبلاگ خوش آمدید</h1>
        </div>
    </div>
    
    <!-- اخبار -->
    <div class="container d-flex justify-content-center flex-wrap my-5">
        <h2 class="text-center my-5">اخبار</h2>
        @foreach($news as $item)
            <a href="#">
                <div class="aaa card col-md-4 mx-2 ">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100" src='{{URL::asset("$item->image")}}' alt="Card image">
                    </div>
                    <div>
                        <h4 class="my-2 text-center">{{ $item->title }}</h4>
                        <div class="my-3 p-2 card-txt">
                            {{ $item->short_text }}
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

@endsection