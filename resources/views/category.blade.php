@extends('master')

@section('content')
    <div>
        <h2 class="text-center my-5">{{ $categoryDetail->name }}</h2>
        @if ($categoryDetail->description)
            <p class="text-justify">{{ $categoryDetail->description }}</p>
        @endif
        <div class="d-flex flex-wrap justify-content-center align-items-stretch my-5">
            @foreach($categories as $item)
                <a href="{{ route('details', ['id' => $item->news_id]) }}" class="card col-md-4 m-3">
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
                    </div>
                </a>              
            @endforeach
        </div>
    </div>
@endsection