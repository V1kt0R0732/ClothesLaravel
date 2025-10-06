@extends('client.layouts.layout', ['title' => 'Корзина'])

@section('content')

    <div class="container py-5">
        <h2 class="mb-4">🛒 Моя корзина</h2>

        @if(empty($clothes->all()))
            <div class="alert alert-info" role="alert">
                Ваша корзина пуста.
            </div>
        @else

        <form id="basket-recalc-form" action="{{ route('basket.recalc') }}" method="POST">
            @csrf
            @foreach($clothes as $item)
            <div class="card mb-3">
                <div class="card-body">
                    <!-- Товар 1 -->
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{Storage::url($item->photo_name)}}" class="img-fluid rounded" alt="Фото товару" style="max-height: 100px;">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1"><a class="cart-href" href="{{route('catalog.show',[$item->storage_cloth_id, 'photo_id'=>$item->photo_id])}}">{{$item->cloth_name}}</a></h5>
                            <p class="text-muted mb-0">{{$item->color_name}} | {{$item->size_name}} | {{$item->body_shape_name}}</p>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="count_{{$item->storage_cloth_id}}" class="form-control text-center" value="{{$basket[$item->storage_cloth_id]['quantity']}}" min="1" max="{{$item->count}}">
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="fw-bold">{{$basket[$item->storage_cloth_id]['quantity']}} x {{$item->price}}₴</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <a class="btn btn-outline-danger btn-sm" href="{{route('basket.remove', $item->storage_cloth_id)}}">
                                ✕
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Итог -->
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Всього:</h5>
                    <h4 class="fw-bold mb-0">{{$totalPrice}}₴</h4>
                </div>
            </div>

{{--    Кнопка очищення корзини    --}}


            <div class="text-end mt-4">
                @if(!empty($clothes->all()))
                    <div class="me-2 d-inline">
                        <a class="btn btn-outline-danger"
                           onclick="event.preventDefault();
                                                     document.getElementById('basket-clear-form').submit();">
                            Очистити корзину
                        </a>
                    </div>
                @endif
                <a class="btn btn-outline-secondary me-2" href="{{route('catalog')}}">До каталогу</a>
                <input class="btn btn-secondary" type="submit" value="Перерахувати">
                <a class="btn btn-success" href="{{route('order.index')}}">Оформити замовлення</a>
            </div>
        </form>

        <form id="basket-clear-form" action="{{ route('basket.clear') }}" method="POST" class="d-none">
            @csrf
        </form>
        @endif
    </div>



@endsection
