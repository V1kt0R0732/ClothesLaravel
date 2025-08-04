@extends('client.layouts.layout', ['title' => 'Главная страница'])

@section('content')
<section class="banner text-white text-center d-flex align-items-center justify-content-center mb-5">
    <div class="container">
        <h2 class="display-5 fw-bold">Новая коллекция весна-лето 2024</h2>
        <p class="lead">Стильная одежда для всей семьи</p>
        <a href="{{ route('catalog') }}" class="btn btn-danger btn-lg mt-3">Смотреть каталог</a>
    </div>
</section>
<main>
    <div class="container">
        <h2 class="text-center mb-4">Популярные товары</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="images/tshirt.jpg" class="card-img-top" alt="Футболка">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Футболка мужская</h5>
                        <p class="card-text text-danger fw-bold mb-3">990 ₽</p>
                        <button class="btn btn-danger mt-auto add-to-cart">В корзину</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="images/dress.jpg" class="card-img-top" alt="Платье">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Платье женское</h5>
                        <p class="card-text text-danger fw-bold mb-3">1990 ₽</p>
                        <button class="btn btn-danger mt-auto add-to-cart">В корзину</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="images/jeans.jpg" class="card-img-top" alt="Джинсы">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Джинсы</h5>
                        <p class="card-text text-danger fw-bold mb-3">2490 ₽</p>
                        <button class="btn btn-danger mt-auto add-to-cart">В корзину</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="images/jacket.jpg" class="card-img-top" alt="Куртка">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Куртка демисезонная</h5>
                        <p class="card-text text-danger fw-bold mb-3">3990 ₽</p>
                        <button class="btn btn-danger mt-auto add-to-cart">В корзину</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
