@extends('client.layouts.layout', ['title' => 'Успішно оформлене замовлення'])

@section('assets')
    @vite(['resources/css/client/order_success.css'])
@endsection

@section('content')
    <div class="success-box">
        <div class="success-icon mb-3">✅</div>
        <h3 class="mb-3">Дякуємо за замовлення!</h3>
        <p class="text-muted">
            Ваше замовлення успішно оформлене.<br>
            Найближчим часом з вами зв’яжеться наш менеджер для підтвердження деталей.
        </p>
        <div class="mt-4">
            <a href="{{route('catalog')}}" class="btn btn-primary me-2">До каталогу</a>
            <a href="{{route('cabinet.orders')}}" class="btn btn-outline-success">Мої замовлення</a>
        </div>
    </div>
@endsection
