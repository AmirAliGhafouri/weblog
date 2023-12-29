@extends('layouts.admin.master')
@section('content')
    <div class="form-background w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex my-5 flex-row-reverse shdow">
                        <div class="col-lg-6 d-flex justify-content-center align-items-center bg-dark">
                            <img class="img-fluid img-responsive rounded form-img"  src='{{URL::asset("images/backgrounds/Registratioin.png")}}'>
                        </div>
                        <div class="col-lg-6 pl-md-5 form-container p-5 bg-white">
                            <h2 class="display-5 text-center mb-5"> افزودن ادمین جدید </h2>
                            <form method="POST" action="{{ route('adminsAdd') }}">
                                @csrf
                                <div class="form-group text-right my-4">
                                    <label for="first_name">نام :</label>

                                    <input type="text" class="form-control @error('first_name') {{'is-invalid'}} @enderror" id="first_name" name="first_name" >
                                    @error('first_name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="last_name">نام خانوادگی :</label>

                                    <input type="text" class="form-control @error('last_name') {{'is-invalid'}} @enderror" id="last_name" name="last_name" >
                                    @error('last_name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="username">نام کاربری :</label>

                                    <input type="text" class="form-control @error('username') {{'is-invalid'}} @enderror" id="username" name="username" >
                                    @error('username')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="phone_number">شماره موبایل  :</label>

                                    <input type="text" class="form-control @error('phone_number') {{'is-invalid'}} @enderror" id="phone_number" name="phone_number" >
                                    @error('phone_number')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="email">ایمیل :</label>

                                    <input type="text" class="form-control @error('email') {{'is-invalid'}} @enderror" id="email" name="email">
                                    @error('email')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="password">رمز عبور :</label>
                                    <input type="password" class="form-control @error('password') {{'is-invalid'}} @enderror" id="password" name="password">
                                    @error('password')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="password_confirmation"> تکرار رمز عبور :</label>
                                    <input type="password" class="form-control @error('password_confirmation') {{'is-invalid'}} @enderror" id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-center text-center">
                                    <button type="submit" class="btn btn-main px-5">ثبت‌نام</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
