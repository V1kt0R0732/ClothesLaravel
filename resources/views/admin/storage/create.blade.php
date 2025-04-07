@extends('admin.layouts.layout', ['title'=>'Додавання одягу'])

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
        <form id="add-clothing-form" action="{{ route('storage.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Товар -->
            <input type="hidden" name="cloth_id" value="{{ $clothes->cloth_id }}">

            <!-- Колір -->
            <div class="mb-3">
                <label for="color" class="form-label">Колір</label>
                <select name="color_id" id="color" class="form-select">
                    @foreach($colors as $color)
                        <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Розмір -->
            <div class="mb-3">
                <label for="size" class="form-label">Розмір</label>
                <select name="size_id" id="size" class="form-select">
                    @foreach($sizes as $size)
                        <option value="{{ $size->size_id }}">{{ $size->size_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Тип тіла -->
            <div class="mb-3">
                <label for="body_shape" class="form-label">Розмір</label>
                <select name="body_shape_id" id="body_shape" class="form-select">
                    @foreach($bodyShapes as $bodyShape)
                        <option value="{{ $bodyShape->body_shape_id }}">{{ $bodyShape->body_shape_name }}</option>
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
                <input type="number" name="count" class="form-select" placeholder="1-100" min="1">
            </div>

            <!-- Кнопка отправки -->
            <input type="submit" class="btn btn-primary" name="send" value="Додати">
        </form>
    </div>

</div>

@endsection
