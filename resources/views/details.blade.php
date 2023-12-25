@extends('master')

@section('content')
    <div class="container">
        <div class="row my-5 d-flex flex-row-reverse">
            <div class="col-lg-6">
                <img src='{{ URL::asset("$newsDetails->image") }}' class="img-fluid shadow" alt="{{ $newsDetails->title }}">
            </div>
            <div class="col-lg-6 pl-md-5 d-flex align-items-end">
                <h2 class="display-4 mb-3">{{ $newsDetails->title }}</h2>
                <h3>{{ $newsDetails->created_at }}</h3>
            </div>
        </div>

        <div class="text-justify">
            <p>{{ $newsDetails->long_text }}</p>                      
        </div>
    </div>
@endsection