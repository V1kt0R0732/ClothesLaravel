<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (иконки) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Свои стили -->
    @vite(['resources/css/style.css', 'resources/js/script.js'])

</head>
<body>

<!-- Верхняя панель -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">

        <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>

        <div class="ms-auto">
            <h4>{{ $title }}</h4>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <i class="fa fa-bell mx-3"></i>
            <i class="fa fa-envelope mx-3"></i>

            <!-- Выпадающее меню пользователя -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" id="userDropdown">
                    <img src="https://via.placeholder.com/30" class="rounded-circle"> Admin
                </button>
                <ul class="dropdown-menu" id="userMenu">
                    <li><a class="dropdown-item" href="#">Профиль</a></li>
                    <li><a class="dropdown-item" href="#">Настройки</a></li>
                    <li><a class="dropdown-item text-danger" href="#">Выйти</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Контейнер с боковым меню и контентом -->
<div class="d-flex">
    <!-- Боковое меню -->
    <nav id="sidebar" class="bg-dark text-white">
        <div class="p-3">
            <h4 class="text-center">*Назва сайту</h4>
            <div class="user-info text-center">
                <img src="https://via.placeholder.com/50" class="rounded-circle mb-2">
                <p>*Ім`я робітника</p>
                <small>*Посада</small>
            </div>
            <hr>
            <ul class="nav flex-column">
                <!-- Категорії -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="fa fa-home"></i> Категорії <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('cat.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('cat.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Цвета -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="fa fa-pencil"></i> Цвета <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('color.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('color.create') }}">Додати</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Кнопка скрытия бокового меню -->
        <button id="hide-menu" class="btn btn-light"><i class="fa fa-angle-left"></i></button>
    </nav>

    <!-- Основной контент -->
    <main class="flex-grow-1 p-4">
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
        @endif
        <div>
            @yield('content')
        </div>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
