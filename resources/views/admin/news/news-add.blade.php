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
                            <h2 class="display-5 text-center mb-5"> خبر جدید </h2>
                            <form method="POST" action="{{ route('newsAdd') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group text-right my-4">
                                    <label for="title">عنوان :</label>

                                    <input type="text" class="form-control @error('title') {{'is-invalid'}} @enderror" id="title" name="title" >
                                    @error ('title')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="short_text">متن کوتاه :</label>
                                    <textarea  class="form-control @error('short_text') {{'is-invalid'}} @enderror" id="short_text" name="short_text" rows="2">

                                    </textarea>
                                    @error ('short_text')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="long_text">متن بلند :</label>
                                    <textarea  class="form-control @error('long_text') {{'is-invalid'}} @enderror" id="long_text" name="long_text" rows="10">

                                    </textarea>
                                    @error ('long_text')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-right my-4">
                                    <label for="image" class="form-label">تصویر خبر</label>
                                    <input class="form-control @error('image') {{'is-invalid'}} @enderror" type="file" id="image" name="image">
                                    @error ('image')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-check text-right my-4">
                                    @foreach ($categories as $category)
                                        <input type="checkbox" value="{{ $category->id }}" id="flexCheckDefault" name="categories[]">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $category->name }}
                                        </label>
                                    @endforeach
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
