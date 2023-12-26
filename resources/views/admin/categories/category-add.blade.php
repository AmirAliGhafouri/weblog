@extends('admin.master')
@section('content')
    <div class="form-background w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex my-5 flex-row-reverse shdow">
                        <div class="col-lg-6 d-flex justify-content-center align-items-center bg-dark">
                            <img class="img-fluid img-responsive rounded"  src='{{URL::asset("images/backgrounds/Registratioin.png")}}'>
                        </div>
                        <div class="col-lg-6 pl-md-5 form-container p-5 bg-white">
                            <h2 class="display-5 text-center mb-5">دسته‌بندی جدید</h2>
                            <form method="POST" action="{{ route('addCategory') }}">
                                @csrf
                                <div class="form-group text-right my-4">
                                    <label for="name">عنوان :</label>

                                    <input type="text" class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" >
                                    @error ('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="description">توضیحات  :</label>
                                    <textarea  class="form-control @error('description') {{'is-invalid'}} @enderror" id="description" name="description" rows="2"></textarea>
                                    @error ('description')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-center text-center">
                                    <button type="submit" class="btn btn-main px-5">اضافه کردن</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
