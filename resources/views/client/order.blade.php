@extends('client.layouts.layout', ['title' => 'Оформлення замовлення'])

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Оформлення замовлення</h2>
        <form action="{{route('order.add')}}" method="post" id="order-form">
            @csrf

        <div class="row">
                <!-- Левая часть: форма -->
                <div class="col-lg-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Дані покупця</h5>

                            <div>
                                <div class="mb-3">
                                    <label class="form-label">ФІО</label>
                                    <input name="name" type="text" class="form-control" @if($user->name) value="{{$user->name}}" @else placeholder="Введіть имя" @endif required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control" @if($user->email) value="{{$user->email}}" @else placeholder="Введіть email" @endif required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Телефон</label>
                                    <input name="phone" type="tel" class="form-control" placeholder="+38 (___) ___-__-__" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Адреса доставки</label>
                                    <input name="adress" type="text" class="form-control" placeholder="Город, улица, дом, квартира" required>
                                </div>

                                <h5 class="mt-4 mb-3">Спосіб доставки</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery" id="delivery1" checked>
                                    <label class="form-check-label" for="delivery1">
                                        Кур'єром (доставка 80₴)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery" id="delivery2">
                                    <label class="form-check-label" for="delivery2">
                                        Самовивіз з магазину (безкоштовно)
                                    </label>
                                </div>

                                <h5 class="mt-4 mb-3">Спосіб оплати</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="pay1" checked>
                                    <label class="form-check-label" for="pay1">
                                        Карткой онлайн
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="pay2">
                                    <label class="form-check-label" for="pay2">
                                        Готівкою при отриманні
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Правая часть: заказ -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Ваше замвлення</h5>

                            @foreach($clothes as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>
                                        <img width="100px" src="{{Storage::url($item->photo_name)}}" class="rounded" alt="">
                                        {{$item->cloth_name}} (x{{$basket[$item->storage_cloth_id]['quantity']}})
                                    </span>
                                    <span class="d-flex align-items-center">{{$item->price * $basket[$item->storage_cloth_id]['quantity']}} ₴</span>
                                </div>
                            @endforeach

                            <hr>
    {{--                        <div class="d-flex justify-content-between mb-2">--}}
    {{--                            <span>Доставка</span>--}}
    {{--                            <span>80 ₴</span>--}}
    {{--                        </div>--}}
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Всього</span>
                                <span>{{$totalPrice}} ₴</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <a class="btn btn-danger w-10 mt-4" href="{{route('basket.index')}}" >Назад до корзини</a>
                                <input type="submit" name="send" class="btn btn-success w-10 mt-4" value="Підтвердити замовлення" >
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
@endsection
