@extends('layouts.default.master')

@section('content')
    <!-- نوار زیر هدر -->
    <div class="topbar m-0">
        <div class="py-5">
            <h1 class="text-center my-5 py-5">به این وبلاگ خوش آمدید</h1>
        </div>
    </div>
    
    <!-- اخبار -->
    <div>
        <h2 class="text-center my-5">اخبار</h2>
        <div class="d-flex flex-wrap justify-content-center align-items-stretch my-5">
            @foreach($news as $item)
                <a href="{{ route('details', ['id' => $item->id]) }}" class="card col-md-4 m-3">
                    <div>
                        <div class="overflow-hidden card-imag-container d-flex align-items-center">
                            <img class="img-fluid w-100" src='{{URL::asset("$item->image")}}' alt="Card image">
                        </div>
                        <div>
                            <h4 class="my-2 text-center">{{ $item->title }}</h4>
                            <div class="mt-3 mb-5 p-2 card-txt">
                                {{ $item->short_text }}
                            </div>
                            <p class="time-txt">{{ $item->created_at }}</p>
                        </div>
                        <div class="ctg-txt">
                            @foreach ($item->categories as $category)
                                <span class="badge bg-warning text-dark">{{ $category->name }}</span>
                            @endforeach
                        </div>   
                    </div>
                </a>              
            @endforeach
        </div>
    </div>

@endsection