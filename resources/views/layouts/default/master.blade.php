<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="{{URL::asset('bootstrap-5.3.2-dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('icon/all.css')}}">

        <script src="{{URL::asset('bootstrap-5.3.2-dist/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{URL::asset('bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('icon/all.js')}}"></script>
    </head>
    <body>
        @include('layouts.default.header')
        @yield('content')
        @include('layouts.default.footer')
    </body>
</html>
