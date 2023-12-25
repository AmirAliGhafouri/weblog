<header class="bg-dark m-0">
    <nav class="navbar navbar-expand-md navbar-dark text-white shadow-sm">
        <div class="container">
            <!-- لوگوی سایت -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ URL::asset('images/backgrounds/logo.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- لینک ها -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <!-- لینک های کاربرانی که وارد حساب خود نشده اند -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">ورود</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">ثبت‌نام</a>
                            </li>
                        @endif

                    <!-- لینک های کاربرانی که وارد حساب خود شده اند -->
                    @else
                        <li class="nav-item dropdown">
                            <div aria-labelledby="navbarDropdown">
                                <a class="nav-link text-white" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    خروج
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>