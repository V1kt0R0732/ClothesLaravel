@extends('admin.layouts.layout', ['title'=>'Редагування одягу (Детально)'])

@section('content')
    <div class="d-flex">
        <div class="col-5">
            <h2>Глобальні параметри</h2>
            <div class="mb-3">
                <label for="name" class="form-label">Ім'я</label>
                <input name="name" type="text" class="form-control" id="name" value="{{ $clothes->cloth_name }}" disabled>
            </div>

            <!-- Ціна -->
            <div class="mb-3">
                <label for="price" class="form-label">Ціна</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">₴</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="{{ $clothes->price }}" disabled>
                </div>
            </div>

            <!-- Категорія -->
            <div class="mb-3">
                <label for="category" class="form-label">Категорія</label>
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="{{ $clothes->category_name }}" disabled>
            </div>

            <!-- Країна виробник -->
            <div class="mb-3">
                <label for="supplier" class="form-label">Виробник</label>
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="{{ $clothes->supplier_name }}" disabled>
            </div>

            <!-- Матеріали (multiple select) -->
            <div class="mb-3">
                <label for="materials" class="form-label">Матеріали</label>
                <select name="materials_id[]" id="materials" class="form-select" multiple disabled>
                    @foreach($materials as $material)
                        <option value="{{ $material->material_id }}">{{ $material->material_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Сезон (multiple select) -->
            <div class="mb-3">
                <label for="season" class="form-label">Сезон</label>
                <select name="seasons_id[]" id="season" class="form-select" multiple disabled>
                    @foreach($seasons as $season)
                        <option value="{{ $season->season_id }}">{{ $season->season_name }}</option>
                    @endforeach
                </select>
            </div>

            @if($properties->isNotEmpty())
                <!-- Доп параметри -->
                <div class="mb-3">
                    <label for="properties" class="form-label">Додаткові параметри</label>
                    <select name="properties[]" id="season" class="form-select" multiple disabled>
                        @foreach($properties as $property)
                            <option value="{{ $property->property_id }}">{{ $property->property_name }}: {{$property->property_value}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Опис -->
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" class="form-control" rows="4" disabled>{{ $clothes->description }}</textarea>
            </div>
        </div>
        <div class="col-1">

        </div>
        <div class="col-5">
            <h2>Особливості товара</h2>
            <div class="mb-3">
                <label for="photo" class="form-label">Фото товара</label>
                <div class="container text-center mt-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        <div class="col">
                            <div class="text-primary fw-bold">Головне Фото</div>
                        </div>
                    </div>
                </div>
                <div class="container text-center mt-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        @csrf
                        @foreach($photos as $photo)
                        <div class="col">
                            <div class="card h-100 photo-radio @if($photo->status) main-photo @else selectable-photo @endif {{ $photo->status ? 'selected' : '' }}" data-photo-id="{{ $photo->photo_id }}">
                                @if(!$photo->status)
                                    <span class="checkmark">✔</span>
                                @endif

                                <img src="{{ Storage::url($photo->photo_name) }}" class="card-img-top" alt="Фото" style="object-fit: cover; height: 150px;">

                                <form action="{{ route('storage.photoDestroy') }}" method="post" class="card-body" onsubmit="if(confirm('Ви дійсно хочите видалити це фото?')){return true}else{return false}">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="id" value="{{$photo->photo_id}}">
                                    @if($photo->photo_name != 'images/noPhoto.png')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i> Видалити
                                    </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <form id="add-clothing-form" action="{{ route('storage.update', ['storage'=>$storage->storage_cloth_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <!-- Товар -->
                <input type="hidden" name="cloth_id" value="{{ $clothes->cloth_id }}">
                <input type="hidden" name="photo_id" id="mainPhotoInput">



                <!-- Photo -->


                <!-- Глобальні товари -->
                <div class="mb-3">
                    <label for="cloth_id" class="form-label">Глобальний товар</label>
                    <select name="cloth_id" id="cloth_id" class="form-select">
                        @foreach($AllClothes as $clothes)
                            <option value="{{ $clothes->cloth_id }}" {{$clothes->cloth_id == $storage->cloth_id ? 'selected' : ''}}>{{ $clothes->cloth_name }} | {{ $clothes->cloth_id }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Колір -->
                <div class="mb-3">
                    <label for="color" class="form-label">Колір</label>
                    <select name="color_id" id="color" class="form-select">
                        @foreach($AllColors as $color)
                            <option value="{{ $color->color_id }}"  {{$color->color_id == $storage->color_id ? 'selected' : ''}}>{{ $color->color_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Розмір -->
                <div class="mb-3">
                    <label for="size" class="form-label">Розмір</label>
                    <select name="size_id" id="size" class="form-select">
                        @foreach($AllSizes as $size)
                            <option value="{{ $size->size_id }}"  {{$size->size_id == $storage->size_id ? 'selected' : ''}}>{{ $size->size_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Тип тіла -->
                <div class="mb-3">
                    <label for="body_shape" class="form-label">Тип тіла</label>
                    <select name="body_shape_id" id="body_shape" class="form-select">
                        @foreach($AllBodyShapes as $bodyShape)
                            <option value="{{ $bodyShape->body_shape_id }}" {{$bodyShape->body_shape_id == $storage->body_shape_id ? 'selected' : ''}}>{{ $bodyShape->body_shape_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Фото -->
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Додати фото</label>
                    <input name="photo[]" class="form-control" type="file" id="formFileMultiple" multiple>
                </div>


                <!-- Кількість на складі -->
                <div class="mb-3">
                    <label for="count" class="form-label">Кількість на складі</label>
                    <input type="number" name="count" class="form-select" value="{{$storage->count}}" placeholder="1-100" min="1">
                </div>

                <!-- Кнопка отправки -->
                <input type="submit" class="btn btn-primary" name="send" value="Оновити">
            </form>
        </div>

    </div>

@endsection
