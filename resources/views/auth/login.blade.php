@extends('layouts.default.master')

@section('content')
<div class="form-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex flex-row-reverse my-5 shdow">
                    <div class="col-lg-6 d-flex justify-content-center align-items-center bg-dark">
                        <img class="img-fluid img-responsive form-img"  src='{{URL::asset("images/backgrounds/login.png")}}'>
                    </div>
                    <div class="col-lg-6 pl-md-5 bg-white p-5">
                        <h2 class="display-5 text-center mb-5">ورود</h2>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group text-right my-4">
                                <label for="email">ایمیل :</label>
                                <input type="email" class="form-control @error('email') {{'is-invalid'}} @enderror" id="email" name="email">
                                @error('email')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group text-right my-4">
                                <label for="password">رمز عبور :</label>
                                <input type="password" class="form-control @error('password') {{'is-invalid'}} @enderror" id="password" name="password" >
                                @error('password')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main px-5">ورود</button>
                            </div>
                        </form>
                        <p class="text-center my-5">قبلا ثبت نام نکرده اید؟<a href="{{ route('register') }}"><b> ثبت‌نام </b></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
