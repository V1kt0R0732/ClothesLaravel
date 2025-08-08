@extends('client.layouts.layout', ['title'=>'Каталог товарів'])

@section('content')

    <!-- Каталог -->
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <form id="searchForm" class="d-flex" action="{{ route('catalog') }}" method="GET">
                    <input name="search" type="text" class="form-control me-2" placeholder="Пошук товарів..." id="searchInput" value="{{ $search ?? '' }}">
                    <input type="hidden" name="category" id="categoryInput" value="{{ $selectedCategory ?? 0 }}">
                    <input type="hidden" name="supplier" id="supplierInput" value="{{ $selectedSupplier ?? 0 }}">
                    <input type="hidden" name="material" id="materialInput" value="{{ $selectedMaterial ?? 0 }}">
                    <input type="hidden" name="size" id="sizeInput" value="{{ $selectedSize ?? 0 }}">
                    <input type="hidden" name="price" id="priceInput" value="{{ $selectedPrice ?? 0 }}">
                    <input type="hidden" name="bodyShape" id="bodyShapeInput" value="{{ $selectedBodyShape ?? 0 }}">
                    <input type="hidden" name="color" id="colorInput" value="{{ $selectedColor ?? 0 }}">
                    <input type="hidden" name="sort" id="sortInput" value="{{ $sort ?? '' }}">
                    <button type="submit" class="btn btn-primary">Поиск</button>
                    <a class="btn btn-secondary ms-2" href="{{ route('catalog') }}">Сбросить</a>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- Фильтр -->
            <aside class="col-md-3 mb-4">
                <h5>Фильтр</h5>
                <form id="filterForm" action="{{ route('catalog') }}" method="GET">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <div class="mb-3">
                        <label class="form-label">Категория</label>
                        <select class="form-select" id="categoryFilter" name="category">
                            <option value="0">Все</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->category_id) ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Виробник</label>
                        <select class="form-select" id="brandFilter" name="supplier">
                            <option value="0">Все</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}" {{ (isset($selectedSupplier) && $selectedSupplier == $supplier->supplier_id) ? 'selected' : '' }}>
                                    {{ $supplier->supplier_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Розмір</label>
                        <select class="form-select" id="sizeFilter" name="size">
                            <option value="0">Всі</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->size_id }}" {{ (isset($selectedSize) && $selectedSize == $size->size_id) ? 'selected' : '' }}>
                                    {{ $size->size_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Колір</label>
                        <select class="form-select" id="colorFilter" name="color">
                            <option value="0">Всі</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->color_id }}" {{ (isset($selectedColor) && $selectedColor == $color->color_id) ? 'selected' : '' }}>
                                    {{ $color->color_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Тип Фігури</label>
                        <select class="form-select" id="bodyShapeFilter" name="bodyShape">
                            <option value="0">Всі</option>
                            @foreach($bodyShapes as $bodyShape)
                                <option value="{{ $bodyShape->body_shape_id }}" {{ (isset($selectedBodyShape) && $selectedBodyShape == $bodyShape->body_shape_id) ? 'selected' : '' }}>
                                    {{ $bodyShape->body_shape_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Розмір</label>
                        <select class="form-select" id="sizeFilter" name="size">
                            <option value="0">Всі</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->size_id }}" {{ (isset($selectedSize) && $selectedSize == $size->size_id) ? 'selected' : '' }}>
                                    {{ $size->size_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Сортувати</label>
                        <select class="form-select" id="sizeFilter" name="sort">
                            <option value="0">Всі</option>
                            <option value="price_asc" {{ (isset($sort) && $sort == 'price_asc') ? 'selected' : '' }}>Ціна: від низької до високої</option>
                            <option value="price_desc" {{ (isset($sort) && $sort == 'price_desc') ? 'selected' : '' }}>Ціна: від високої до низької</option>
                            <option value="name_asc" {{ (isset($sort) && $sort == 'name_asc') ? 'selected' : '' }}>Назва: від А до Я</option>
                            <option value="name_desc" {{ (isset($sort) && $sort == 'name_desc') ? 'selected' : '' }}>Назва: від Я до А</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Материал</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($materials as $material)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="materialFilter{{$material->material_id}}" name="material[]" value="{{$material->material_id}}" {{ (isset($selectedMaterial) && in_array($material->material_id, explode(',', $selectedMaterial))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="materialFilter{{$material->material_id}}">
                                        {{$material->material_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Одяг до - </label>
                        <span id="priceValue"></span>
                        <input type="range" class="form-range" name="price" min="{{$prices['min']}}" max="{{$prices['max']}}" step="50" value="{{$selectedPrice}}" id="priceRange">
                        <div class="d-flex justify-content-between">
                            <span>{{$prices['min']}}₴</span>
                            <span>{{$prices['max']}}₴</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Применить</button>
                    </div>
                    @if((isset($search) && !empty($search)) || isset($selectedCategory) || isset($selectedSupplier) || isset($selectedMaterial) || isset($selectedSize) || isset($selectedBodyShape) || isset($selectedColor) || isset($sort))
                        <div class="mb-3">
                            <a href="{{ route('catalog') }}" class="btn btn-secondary w-100">Скинути Фільтри</a>
                        </div>
                    @endif
                </form>
                <div class="mb-3">
                    <div class="alert alert-info bg-warning bg-opacity-25 rounded" role="alert">
                        Знайдено товарів: <strong>{{ $clothes->total() }}</strong>
                    </div>
                </div>
            </aside>
            <!-- Товары -->

            @if(isset($clothes) && $clothes->isEmpty())
                <div class="col-md-9">
                    <div class="alert alert-info" role="alert">
                        Товары не найдены.
                    </div>
                </div>
            @else
            <section class="col-md-9">
                <div class="row" id="productsList">
                    <!-- Карточки товаров (пример для замены на Blade) -->
                    @foreach($clothes as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="{{route('catalog.show',['id'=>$item->storage_cloth_id,'photo_id'=>$item->photo_id])}}"><img src="{{Storage::url($item->photo_name)}}" class="card-img-top" alt="Детская куртка"></a>
                            <div class="card-body d-flex flex-column">
                                <a href="{{route('catalog.show',[$item->storage_cloth_id, 'photo_id'=>$item->photo_id])}}" class="cart-href">
                                    <h5 class="card-title">{{$item->cloth_name}}</h5>
                                </a>
                                <p class="card-text mb-4">{{$item->price}}₴</p>
                                <a href="#" class="btn btn-primary mt-auto">В корзину</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Пагинация -->
                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        {{$clothes->links()}}
                    </ul>
                </nav>
            </section>
            @endif
        </div>
    </div>

@endsection
