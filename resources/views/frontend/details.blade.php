@extends('layouts.default.master')

@section('content')
    <div class="container">
        <div class="row my-5 d-flex flex-row-reverse">
            <div class="col-lg-6 d-flex align-items-center news-img-container">
                <img src='{{ URL::asset("$newsDetails->image") }}' class="img-fluid shadow" alt="{{ $newsDetails->title }}">
            </div>
            <div class="col-lg-6 pl-md-5 d-flex align-items-end">
                <div>
                    <h2 class="display-4 mb-3">{{ $newsDetails->title }}</h2>
                    <div class="my-3">
                        تعداد بازدید <strong id="view">{{ $viewCount }}</strong>
                    </div>
                    <h3>{{ $newsDetails->created_at }}</h3>
                    <div>
                        @foreach ($newsCategories as $item)
                            <a href="{{ route('category', ['name' => $item->name]) }}" class="badge bg-warning text-dark mx-2">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="text-justify">
            <p>{{ $newsDetails->long_text }}</p>                      
        </div>
    </div>
@endsection

<script>

    /**
     * ajax تابع مربوط به 
     */
    function viewCount() {
        // خبر id
        var newsId = "{{ $newsDetails->id }}"
        // console.log(newsId)
        $.ajax({
            url: '/news-view/' + newsId,
            type: 'GET',
            success: function (data) {
                $('#view').html(data);
            },
            error: function (error) {
                console.log('error:', error);
            }
        });
    }

    // هر 10 ثانیه viewCount اجرای تابع
    setInterval(viewCount, 10000);
</script>