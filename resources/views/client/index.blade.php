@extends('client.layouts.layout', ['title' => 'Главная страница'])

@section('content')
<section class="banner text-white text-center d-flex align-items-center justify-content-center mb-5">
    <div class="container">
        <h2 class="display-5 fw-bold">{{ __('main.indexTitle') }}</h2>
        <p class="lead">Стильная одежда для всей семьи</p>
        <a href="{{ route('catalog') }}" class="btn btn-danger btn-lg mt-3">{{ __('main.catalogButton') }}</a>
    </div>
</section>
<main>
    <div class="container">
        <h2 class="text-center mb-4">Випадкові Товари</h2>
        <div class="row g-4 justify-content-center">
            @foreach($clothes as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <a href="{{route('catalog.show',['id'=>$item->storage_cloth_id,'photo_id'=>$item->photo_id])}}"><img src="{{Storage::url($item->photo_name)}}" class="card-img-top" alt="Детская куртка"></a>
                    <div class="card-body d-flex flex-column">
                        <a href="{{route('catalog.show',[$item->storage_cloth_id, 'photo_id'=>$item->photo_id])}}" class="cart-href">
                            <h5 class="card-title">{{$item->cloth_name}}</h5>
                        </a>
                        <p class="card-text mb-4">{{$item->price}}₴</p>
                        <a href="{{route('catalog.show', [$item->storage_cloth_id, 'photo_id'=>$item->photo_id])}}" class="btn btn-primary mt-auto">Детальніше про товар</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
