<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/client/index.css', 'resources/js/client/script.js'])
    @yield('assets')
</head>
<body class="d-flex flex-column min-vh-100">
<header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <h1 class="h3 mb-0 me-4 flex-shrink-0">ClothesShop</h1>
        <nav class="mx-auto">
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="/home">{{ __('main.main') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/catalog">{{ __('main.catalog') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/about">{{ __('main.about') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/contact">{{ __('main.contacts') }}</a></li>
            </ul>
        </nav>
        <div class="d-flex align-items-center ms-4">
            <div class="auth-buttons d-flex me-3">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                            <a class="btn btn-outline-light me-2" href="{{ route('login') }}">{{ __('Ввійти') }}</a>
                    @endif

                    @if (Route::has('register'))
                            <a class="btn btn-danger" href="{{ route('register') }}">{{ __('Зареєструватись') }}</a>
                    @endif
                @else
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('cabinet.main') }}">
                            {{ __('Профіль') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ __('Вийти') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endguest
{{--                <a href="{{route('login')}}" class="btn btn-outline-light me-2">Вхід</a>--}}
{{--                <a href="{{route('register')}}" class="btn btn-danger">Реєстрація</a>--}}
            </div>
            <a href="{{route('basket.index')}}" class="text-decoration-none">
            <div class="cart d-flex align-items-center bg-white text-dark px-3 py-1 rounded-pill">
                <span class="me-1">🛒</span>
                <span id="cart-count">{{session('basket_count') ?? 0}}</span>
            </div>
            </a>
        </div>
    </div>
</header>

<div class="d-flex justify-content-center">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 400px; width: 100%;">
            <strong>Успіх!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 400px; width: 100%;">
            <strong>Помилка!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="max-width: 400px; width: 100%;">
            <strong>Увага!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

@yield('content')


<footer class="bg-dark text-white text-center py-3 mt-5 mt-auto">
    <div class="container">
        <p class="mb-0">&copy; {{__('main.footer')}} </p>
    </div>
</footer>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
