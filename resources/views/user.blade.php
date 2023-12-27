@extends('master')
@section('content')
    <div class="form-background w-100 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex my-5 flex-row-reverse shdow">
                        <div class="col-lg-6 d-flex justify-content-center align-items-center flex-column bg-dark text-white">
                            <h2 class="my-2">
                                <span class="text-title">نام نام‌خانوادگی: </span> {{ $user->first_name }} {{ $user->last_name }}
                            </h2>

                            <p class="my-2">
                                <span class="text-title">نام‌کاربری: </span> {{ $user->username }}
                            </p>

                            <p class="my-2">
                                <span class="text-title">ایمیل: </span>{{ $user->email }}
                            </p>

                            <p class="my-2">
                                <span class="text-title">شماره‌موبایل: </span> {{ $user->phone_number }}
                            </p>
                        </div>
                        <div class="col-lg-6 pl-md-5 form-container p-5 bg-white">
                            <h2 class="display-5 text-center mb-5">ویرایش مشخصات</h2>
                            <form method="POST" action="{{ route('user.edit', ['id', $user->id]) }}">
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

                                <div class="form-center text-center">
                                    <button type="submit" class="btn btn-main px-5">تغییر</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center"> 
                <div class="col-md-12 col-lg-10 bg-light p-3 rounded">
                    <h2 class="text-center mb-5">تغییر رمز عبور</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">رمز قدیمی</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">رمز جدید</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">تکرار رمز جدید</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    تغییر
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
