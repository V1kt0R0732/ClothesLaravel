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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Свои стили -->
    @vite(['resources/css/style.css', 'resources/js/script.js'])

</head>
<body>

<!-- Верхняя панель -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">

        <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>

        <div class="ms-auto">
            <a href="{{ url()->current() }}" class="layoutTitle"><h4>{{ $title }}</h4></a>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <i class="fa fa-bell mx-3"></i>
            <i class="fa fa-envelope mx-3"></i>

            <!-- Выпадающее меню пользователя -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" id="userDropdown">
                    <img src="https://via.placeholder.com/30" class="rounded-circle"> {{Session('user.name')}}
                </button>
                <ul class="dropdown-menu" id="userMenu">
                    <li><a class="dropdown-item" href="{{ route('admin.index') }}">Профіль</a></li>
                    <li><a class="dropdown-item" href="#">Настройки</a></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('admin.logout')}}">Вийти</a></li>
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
                <p>{{Session('user.name')}}</p>
                <small>{{Session('user.permission')}}</small>
            </div>
            <hr>
            <ul class="nav flex-column">

                <!-- Додавання Конкретного товара -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-folder"></i> Storage <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('storage.index') }}">Всі</a></li>
                    </ul>
                </li>

                <!-- Додавання Одягу -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-bookshelf"></i> Одяг <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('clothes.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('clothes.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Категорії -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-tags"></i> Категорії <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('category.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('category.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Цвета -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-palette"></i> Колір <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('color.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('color.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Матеріали -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-postage-fill"></i> Матеріали <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('material.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('material.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Сезони -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-cloud-sun"></i> Сезони <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('season.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('season.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Розмір -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-rulers"></i> Розміри <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('size.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('size.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- Постачальники -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-truck"></i> Виробник <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('supplier.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('supplier.create') }}">Додати</a></li>
                    </ul>
                </li>

                <!-- BodyShape -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-person-bounding-box"></i> BodyShape <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('bodyshape.index') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('bodyshape.create') }}">Додати</a></li>
                    </ul>
                </li>

                @if(Session('user.permission') == 'Owner')
                <!-- Користувачі -->
                <li class="nav-item">
                    <a class="nav-link toggle-submenu" href="#">
                        <i class="bi bi-people-fill"></i> User <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <ul class="submenu">
                        <li><a class="nav-link" href="{{ route('admin.list') }}">Всі</a></li>
                        <li><a class="nav-link" href="{{ route('admin.registerForm') }}">Додати</a></li>
                    </ul>
                </li>
                @endif
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
