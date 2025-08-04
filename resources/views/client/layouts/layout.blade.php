<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/client/index.css', 'resources/js/client/script.js'])
    @yield('assets')
</head>
<body>
<header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <h1 class="h3 mb-0 me-4 flex-shrink-0">ClothesShop</h1>
        <nav class="mx-auto">
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="/home">Головна</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/catalog">Каталог</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/about">Про нас</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/contact">Контакти</a></li>
            </ul>
        </nav>
        <div class="d-flex align-items-center ms-4">
            <div class="auth-buttons d-flex me-3">
                <a href="#" class="btn btn-outline-light me-2">Вхід</a>
                <a href="#" class="btn btn-danger">Реєстрація</a>
            </div>
            <div class="cart d-flex align-items-center bg-white text-dark px-3 py-1 rounded-pill">
                <span class="me-1">🛒</span>
                <span id="cart-count">0</span>
            </div>
        </div>
    </div>
</header>
<body>

@yield('content')


<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">
        <p class="mb-0">&copy; 2024 ClothesShop. Все права защищены.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/main.js"></script>
</body>
</html>
