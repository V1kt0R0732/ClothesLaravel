@extends('admin.layouts.layout', ['title'=>'Відредагувати Глобальну інформацію про одяг'])

@section('content')
    <div class="container mt-4">
        <h2>Редагування одяг</h2>
        <form id="add-clothing-form" action="{{ route('clothes.update', ['clothes'=>$clothes->cloth_id]) }}" method="post">
            @csrf
            @method('PATCH')
            <!-- Ім'я -->
            <div class="mb-3 shadow-sm p-3 bg-body rounded">
                <label for="name" class="form-label">Ім'я</label>
                <input name="name" type="text" class="form-control" id="name" value="{{ $clothes->cloth_name }}" >
            </div>

            <!-- Ціна -->
            <div class="mb-3 shadow-sm p-3 bg-body rounded">
                <label for="price" class="form-label">Ціна</label>
                <input name="price" type="number" class="form-control" id="price" value="{{ $clothes->price }}" placeholder="Введіть ціну" >
            </div>

            <!-- Категорія -->
            <div class="mb-3 shadow-sm p-3 bg-body rounded">
                <label for="category" class="form-label">Категорія</label>
                <select name="category_id" id="category" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ $cat->category_id == $clothes->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Країна виробник -->
            <div class="mb-3 shadow-sm p-3 bg-body rounded">
                <label for="supplier" class="form-label">Поставщик</label>
                <select name="supplier_id" id="supplier" class="form-select">
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->supplier_id }}" {{ $sup->supplier_id == $clothes->supplier_id ? 'selected' : '' }}>{{ $sup->supplier_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 shadow-sm p-3 bg-body rounded">
            <!-- Матеріали (multiple select) -->
                <label for="materials" class="form-label">Матеріали<br></label><br>
                <div class="d-flex">
                    <div class="col-3 m-2">
                        <label for="materials" class="form-label">Присвоєні товару</label>
                        <select id="materials" class="form-select" multiple disabled>
                            @foreach($materials as $material)
                                <option value="{{ $material->material_id }}">{{ $material->material_name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-3 m-2">
                        <label for="materials" class="form-label">Потрібно обрати</label>
                        <select name="materials_id[]" id="materials" class="form-select" multiple>
                            @foreach($AllMaterials as $material)
                                <option value="{{ $material->material_id }}">{{ $material->material_name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="row-auto d-flex">
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="materialCheck" id="flexRadioDefault1" value="add">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Додати
                        </label>
                    </div>
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="materialCheck" id="flexRadioDefault2" value="clear">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Замінити
                        </label>
                    </div>
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="materialCheck" id="flexRadioDefault3" value="stay" checked>
                        <label class="form-check-label" for="flexRadioDefault3">
                            Залишити
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3 shadow-sm p-3 bg-body rounded">
            <!-- Сезон (multiple select) -->
                <label for="season" class="form-label">Сезони</label>
                <div class="mb-3 d-flex">
                    <div class="col-3 m-2">
                        <label for="materials" class="form-label">Присвоєні товару</label>
                        <select id="season" class="form-select" multiple disabled>
                            @foreach($seasons as $season)
                                <option value="{{ $season->season_id }}">{{ $season->season_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 m-2">
                        <label for="materials" class="form-label">Обрати потрібні</label>
                        <select name="seasons_id[]" id="season" class="form-select" multiple>
                            @foreach($AllSeasons as $season)
                                <option value="{{ $season->season_id }}">{{ $season->season_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row-auto d-flex">
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="seasonCheck" id="seasonCheck1" value="add">
                        <label class="form-check-label" for="seasonCheck1">
                            Додати
                        </label>
                    </div>
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="seasonCheck" id="seasonCheck2" value="clear">
                        <label class="form-check-label" for="seasonCheck2">
                            Замінити
                        </label>
                    </div>
                    <div class="col-2 text-center m-1">
                        <input class="form-check-input" type="radio" name="seasonCheck" id="seasonCheck3" value="check" checked>
                        <label class="form-check-label" for="seasonCheck3">
                            Залишити
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3 shadow-sm p-3 bg-body rounded">
            <label for="properties" class="form-label">Додаткові параметри</label>
            <!-- Доп параметри -->
            <div class="mb-3">
                <label for="properties" class="form-label">Додати параметри</label>
                <textarea name="properties" id="properties" class="form-control" rows="1" placeholder="(Назва параметра)*:(значення)* | Наприклад: Розмір:XL,Довжина:150см">@foreach($properties as $prop) {{$prop->property_name}}:{{$prop->property_value}}, @endforeach</textarea>
            </div>
            </div>
            <!-- Опис -->
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Введите описание">{{ $clothes->description }}</textarea>
            </div>

            <!-- Кнопка отправки -->
            <input type="submit" class="btn btn-primary" name="send" value="Додати одяг">
        </form>
    </div>
@endsection
