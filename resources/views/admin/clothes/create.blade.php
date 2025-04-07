@extends('admin.layouts.layout', ['title'=>'Додавання одягу'])

@section('content')
<div class="container mt-4">
    <h2>Додати одяг</h2>
    <form id="add-clothing-form" action="{{ route('clothes.store') }}" method="post">
        @csrf
        <!-- Ім'я -->
        <div class="mb-3">
            <label for="name" class="form-label">Ім'я</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Введіть назву одягу" >
        </div>

        <!-- Ціна -->
        <div class="mb-3">
            <label for="price" class="form-label">Ціна</label>
            <input name="price" type="number" class="form-control" id="price" placeholder="Введіть ціну" >
        </div>

        <!-- Матеріали (multiple select) -->
        <div class="mb-3">
            <label for="materials" class="form-label">Матеріали</label>
            <select name="materials_id[]" id="materials" class="form-select" multiple>
                @foreach($materials as $material)
                    <option value="{{ $material->material_id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Категорія -->
        <div class="mb-3">
            <label for="category" class="form-label">Категорія</label>
            <select name="category_id" id="category" class="form-select">
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Країна виробник -->
        <div class="mb-3">
            <label for="supplier" class="form-label">Поставщик</label>
            <select name="supplier_id" id="supplier" class="form-select">
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->supplier_id }}">{{ $sup->supplier_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Сезон (multiple select) -->
        <div class="mb-3">
            <label for="season" class="form-label">Сезон</label>
            <select name="seasons_id[]" id="season" class="form-select" multiple>
                @foreach($seasons as $season)
                    <option value="{{ $season->season_id }}">{{ $season->season_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Доп параметри -->
        <div class="mb-3">
            <label for="properties" class="form-label">Додаткові параметри</label>
            <textarea name="properties" id="properties" class="form-control" rows="1" placeholder="(Назва параметра)*:(значення)* | Наприклад: Розмір:XL,Довжина:150см"></textarea>
        </div>

        <!-- Опис -->
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Введите описание"></textarea>
        </div>

        <!-- Кнопка отправки -->
        <input type="submit" class="btn btn-primary" name="send" value="Додати одяг">
    </form>
</div>

@endsection
