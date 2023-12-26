<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="{{URL::asset('bootstrap-5.3.2-dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/sidebar.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('icon/all.css')}}">

        <script src="{{URL::asset('bootstrap-5.3.2-dist/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{URL::asset('bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('icon/all.js')}}"></script>
    </head>
    <body class="bg-dark">
        @include('../header')
        <div class="d-flex">
            <div class="side-bar bg-dark">
                <div class="text-center text-title px-2">
                    <h2>داشبورد ادمین</h2>

                </div>
                <ul class="p-0 mt-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="p-3 text-white d-inline-block w-100 @if(request()->is('admin/dashboard*')) {{ 'active-link' }} @endif">
                            اخبار
                        </a>
                    </li>

                    <li>
                        <a href="#" class="p-3 text-white d-inline-block w-100">
                            کاربران
                        </a>
                    </li>

                    <li>
                        <a href="#" class="p-3 text-white d-inline-block w-100">
                            ادمین ها
                        </a>
                    </li>

                    <li>
                        <a href="#" class="p-3 text-white d-inline-block w-100">
                            دسته بندی ها
                        </a>
                    </li>
                </ul>
            </div>

            @yield('content')
        </div>
        @include('../footer')
    </body>
</html>
