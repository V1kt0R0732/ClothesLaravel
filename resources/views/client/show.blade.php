@extends('client.layouts.layout',['title'=>'Детальніше про товар'])

@section('assets')
    @vite(['resources/css/client/show.css'])
@endsection

@section('content')
    <div class="container">
        <div class="product">
            <div class="product-gallery">
                {{--   Додаткові фото товара         --}}
                <img src="{{Storage::url($selected_photo->photo_name)}}" class="selected-image" alt="Футболка Classic Oversize">
                <div class="additional-photos">
                    @foreach($photos as $photo)
                        @if($photo->photo_id != $selected_photo->photo_id)
                            <a href="{{route('catalog.show', ['id'=>$clothes_main->storage_cloth_id, 'photo_id'=>$photo->photo_id])}}" data-lightbox="product-gallery">
                                <img src="{{Storage::url($photo->photo_name)}}" alt="Додаткове фото" class="additional-photo">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            {{--   Додаткові фото товара         --}}


            <div class="product-details">
                <h1>{{$clothes_main->cloth_name}}</h1>

                <!-- Вибір характеристик -->
                <div class="select-fields">
                    {{--
                    <div class="form-group">
                        <div class="btn-group size-selector" role="group">
                            <input type="radio" class="btn-check" name="size" id="sizeS" autocomplete="off">
                            <label class="btn btn-size" for="sizeS">S</label>

                            <input type="radio" class="btn-check" name="size" id="sizeM" autocomplete="off" checked>
                            <label class="btn btn-size" for="sizeM">M</label>

                            <input type="radio" class="btn-check" name="size" id="sizeL" autocomplete="off">
                            <label class="btn btn-size" for="sizeL">L</label>

                            <input type="radio" class="btn-check" name="size" id="sizeXL" autocomplete="off">
                            <label class="btn btn-size" for="sizeXL">XL</label>
                        </div>
                    </div>
                    --}}
                    <!-- Розмір -->
                    <div class="form-group">
                        <label>Розмір:</label>
                        <div class="btn-group" role="group" aria-label="Розмір">
                            @foreach($sizes as $item)
                                @if($item->size_id == $clothes_main->size_id)
                                <button type="button"  class="option-btn-active">
                                    {{$item->size_name}}
                                </button>
                                @else
                                    <a href="{{route('catalog.show', ['id'=>$item->storage_id, 'photo_id'=>$item->photo_id])}}">
                                        <button type="button" class="option-btn" >
                                            {{$item->size_name}}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Колір -->
                    <div class="form-group">
                        <label>Колір:</label>
                        <div class="btn-group" role="group" aria-label="Колір">
                            @foreach($colors as $item)
                                @if($item->color_id == $clothes_main->color_id)
                                    <button type="button" class="option-btn-active">
                                        {{$item->color_name}}
                                    </button>
                                @else
                                    <a href="{{route('catalog.show', ['id'=>$item->storage_id, 'photo_id'=>$item->photo_id])}}">
                                        <button type="button" class="option-btn">
                                            {{$item->color_name}}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Тип тіла -->
                    <div class="form-group">
                        <label>Тип тіла:</label>
                        <div class="btn-group" role="group" aria-label="Тип тіла">
                            @foreach($body_shapes as $item)
                                @if($item->body_shape_id == $clothes_main->body_shape_id)
                                    <button type="button" class="option-btn-active">
                                        {{$item->body_shape_name}}
                                    </button>
                                @else
                                    <a href="{{route('catalog.show', ['id'=>$item->storage_id, 'photo_id'=>$selected_photo])}}">
                                        <button type="button" class="option-btn">
                                            {{$item->body_shape_name}}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Інформаційні характеристики -->
                <div class="info-fields">
                    <p><strong>Матеріал:</strong> {{$materials}}</p>
                    <p><strong>Ціна:</strong> ₴{{$clothes_main->price}}</p>
                    <p><strong>Сезон:</strong> {{$seasons}}</p>
                    <p><strong>Країна виробництва:</strong> {{$clothes_main->supplier_name}}</p>
                    <p><strong>Додатково:<br></strong>
                        @foreach($properties as $property)
                            <strong>{{$property->property_name}} - </strong> {{$property->property_value}}
                        @endforeach
                    </p>
                </div>

                <a class="buy-btn" href="{{ route('basket.add') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('basket-add-form').submit();">
                    {{ __('Buy Button') }}
                </a>

                <form id="basket-add-form" action="{{ route('basket.add') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" name="id" value="{{ $clothes_main->storage_cloth_id }}">
                </form>
            </div>
        </div>

        <div class="description">
            <h2>Опис товару</h2>
            <p>
                {{$clothes_main->description}}
            </p>
        </div>
    </div>
@endsection
