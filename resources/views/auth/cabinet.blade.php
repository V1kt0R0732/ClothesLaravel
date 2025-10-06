@extends('client.layouts.layout', ['title' => 'Особистий кабінет'])

@section('assets')
    @vite(['resources/css/client/cabinet.css'])
@endsection


@section('content')
{{--Alert--}}
{{--Centered--}}
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

<div class="container my-4">
    <div class="row">
        <!-- Бокова панель -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
{{--                    {{dd(Auth::user())}}--}}
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" class="rounded-circle mb-2" alt="Аватар">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
                <ul class="list-group list-group-flush">
                    <a @if($url != 'main') href="{{route('cabinet.main')}}" @endif class="list-group-item list-group-item-action @if($url == "main") active @endif">Мій профіль</a>
                    <a @if($url != "orders") href="{{route('cabinet.orders')}}" @endif class="list-group-item list-group-item-action @if($url == "orders") active @endif">Мої замовлення</a>
                    <a @if($url != "settings") href="{{route('cabinet.settings')}}" @endif class="list-group-item list-group-item-action @if($url == "settings") active @endif">Налаштування</a>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="list-group-item list-group-item-action text-danger">{{ __('Вийти') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>

        <!-- Основний контент -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body tab-content">
                    @yield('module')
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
