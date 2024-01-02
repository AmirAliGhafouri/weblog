@extends('layouts.default.master')

@section('content')
<div class="form-background position-ralative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex flex-row-reverse my-5 shdow">
                    <div class="col-lg-6 d-flex justify-content-center align-items-center bg-dark">
                        <img class="img-fluid img-responsive form-img"  src='{{URL::asset("images/backgrounds/login.png")}}'>
                    </div>
                    <div class="col-lg-6 pl-md-5 bg-white p-5">
                        <h2 class="display-5 text-center mb-5">{{ __('login') }}</h2>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group text-right my-4">
                                <label for="email">{{ __('email') }} :</label>
                                <input type="email" class="form-control @error('email') {{'is-invalid'}} @enderror" id="email" name="email">
                                @error('email')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group text-right my-4">
                                <label for="password">{{ __('password') }} :</label>
                                <input type="password" class="form-control @error('password') {{'is-invalid'}} @enderror" id="password" name="password" >
                                @error('password')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main px-5">{{ __('login') }}</button>
                            </div>
                        </form>
                        <p class="text-center my-5">{{ __('register.ask') }} <a href="{{ route('register') }}"><b> {{ __('register') }} </b></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تعویض زبان -->
    <div class="position-absolute p-2 bg-dark rounded-2 d-flex">
        <div>
            <a href="{{ route('login.language', ['language' => 'fa']) }}" class="text-white m-2 p-1 rounded-2 @if(request()->is('login/fa')) {{ 'active-link' }} @endif">fa</a>
        </div>
        <div>
            <a href="{{ route('login.language', ['language' => 'en']) }}" class="text-white m-2 p-1 rounded-2 @if(request()->is('login/en')) {{ 'active-link' }} @endif">en</a>
        </div>
    </div>
</div>
@endsection
