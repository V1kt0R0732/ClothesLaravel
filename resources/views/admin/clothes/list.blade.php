@extends('admin.layouts.layout', ['title'=>'Загальні критерії одягу'])

@section('content')

    <div class="container-fluid mb-3">
        <form class="d-flex" role="search" action="{{route('clothes.index')}}" method="get">
            <input class="form-control me-2" type="text" name="search" value="{{isset($search) && !empty($search) ? $search : ''}}" placeholder="Пошук товарів" aria-label="Search">
            @if(isset($sort) && !empty($sort) && isset($col) && !empty($col))
                <input type="hidden" name="sort" value="{{$sort}}">
                <input type="hidden" name="col" value="{{$col}}">
            @endif
            <button class="btn btn-outline-success" type="submit">Пошук</button>
            <div class="">
                <a class="btn btn-outline-danger" href="{{route('clothes.index')}}">Скинути</a>
            </div>
        </form>

    </div>

    @if($clothes->IsNotEmpty())

        <table class="table">
            <thead>
            <tr>
                <th class="id">
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'cloth_id'])}}">Id</a>
                </th>
                <th>
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'cloth_name'])}}">Назва</a>
                </th>
                <th>
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'category_id'])}}">Категорія</a>
                </th>
                <th>
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'supplier_id'])}}">Виробник</a>
                </th>
                <th>
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'price'])}}">Ціна</a>
                </th>
                <th>
                    <a href="{{route('clothes.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort,'col'=>'storage_count'])}}">На складі</a>
                </th>
                <th>
                    Додати на склад
                </th>
                <th class="id">
                    Ред
                </th>
                <th class="id">
                    Вид
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($clothes as $item)
{{--                {{print_r($item)}}--}}
                <tr>
                    <td>
                        {{ $item->cloth_id }}
                    </td>
                    <td>
                        {{ $item->cloth_name }}
                    </td>
                    <td>
                        {{ $item->category_name }}
                    </td>
                    <td>
                        {{ $item->supplier_name }}
                    </td>
                    <td>
                        {{ $item->price }}
                    </td>
                    <td>
                        {{ $item->storage_count ?? '0' }}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm">
                            <a href="{{ route('storage.create', ['cloth_id'=>$item->cloth_id]) }}"><i class="bi bi-plus-circle" style="color:green"></i></a>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-sm">
                            <a href="{{ route('clothes.edit', ['clothes'=>$item->cloth_id]) }}"><i class="bi bi-pencil" style="color:blue"></i></a>
                        </button>
                    </td>
                    <td>
                        <form action="" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm delete-btn">
                                <i class="bi bi-trash3-fill" style="color:red"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>Загальна таблиця одягу відсутня</h3>
    @endif

@endsection
