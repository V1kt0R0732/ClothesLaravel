@extends('admin.layouts.layout', ['title'=>'Одяг на складі'])

@section('content')
    <div class="container-fluid mb-3">
        <form class="d-flex" role="search" action="{{route('storage.index')}}" method="get">
            <input class="form-control me-2" type="text" name="search" value="{{isset($search) && !empty($search) ? $search : ''}}" placeholder="Пошук товарів" aria-label="Search">
            @if(isset($sort) && !empty($sort) && isset($col) && !empty($col))
                <input type="hidden" name="sort" value="{{$sort['value']}}">
                <input type="hidden" name="col" value="{{$sort['col']}}">
            @endif
            <button class="btn btn-outline-success" type="submit">Пошук</button>
            <div class="">
                <a class="btn btn-outline-danger" href="{{route('storage.index')}}">Скинути</a>
            </div>
        </form>
        <div>
            <form action="{{route('storage.deleteAll')}}" method="post" onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
                @csrf
                @method('POST')
                <input type="hidden" name="StorageId" id="mainStorageId" value="0">
                <input class="btn btn-outline-danger" value="Видалити виділені товари" type="submit" name="deleteSelected">
            </form>
        </div>
    </div>
    <table class="table">

        <thead>
        <tr>
            <th class="id">
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'id'])}}">Id</a>
            </th>
            <th>
                Фото
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'name'])}}">Назва</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'color'])}}">Колір</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'size'])}}">Розмір</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'count'])}}">К-сть</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'shape'])}}">Тип фігури</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'cat'])}}">Категорія</a>
            </th>
            <th>
                <a href="{{route('storage.index',[isset($search) && !empty($search) ? "search=$search" : '','sort'=>$sort['value'],'col'=>'sup'])}}">Виробник</a>
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
        @foreach($storage as $item)
        <tr class="storage-item-{{$item->storage_cloth_id}}">
            <td>
                {{ $item->storage_cloth_id }}
            </td>
            <td class="storage-select" data-storage-id="{{$item->storage_cloth_id}}">
                <img src="{{ Storage::url($item->photo_name) }}" width="100px">
            </td>
            <td class="storage-select" data-storage-id="{{$item->storage_cloth_id}}">
                {{ $item->cloth_name }}
            </td>
            <td>
                {{ $item->color_name }}
            </td>
            <td>
                {{ $item->size_name }}
            </td>
            <td>
                {{ $item->count }}
            </td>
            <td>
                {{ $item->body_shape_name }}
            </td>
            <td>
                {{ $item->category_name }}
            </td>
            <td>
                {{ $item->supplier_name }}
            </td>
            <td>
                <button class="btn btn-sm">
                    <a href="{{route('storage.edit',['storage'=>$item->storage_cloth_id])}}"><i class="bi bi-pencil" style="color:blue"></i></a>
                </button>
            </td>
            <td>
                <form action="{{ route('storage.destroy',['storage'=>$item->storage_cloth_id]) }}" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
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
    <div class="d-flex justify-content-center" style="margin-top:20px;">
        {{ $storage->links() }}
    </div>

@endsection
