@extends('layouts.default.master')

@section('content')
    <div>
        <h1 class="text-center my-5">اعلان ها</h1>
        <div class="my-5 container">
            @foreach ($notifications as $notification)
                @foreach ($notification->data as $item)
                    <div class="p-5 border">
                        {{ $item }}
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection