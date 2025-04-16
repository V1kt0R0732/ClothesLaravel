@extends('admin.layouts.layout', ['title'=>'Одяг на складі'])

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th class="id">
                Id
            </th>
            <th>
                Фото
            </th>
            <th>
                Назва
            </th>
            <th>
                Колір
            </th>
            <th>
                Розмір
            </th>
            <th>
                К-сть
            </th>
            <th>
                Категорія
            </th>
            <th>
                Виробник
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
        <tr>
            <td>
                {{ $item->storage_cloth_id }}
            </td>
            <td>
{{--                <div style="background-image:url({{  }})"></div> --}}
                <img src="{{ !empty($item->photo_name) ? Storage::url($item->photo_name) : Storage::url('images/noPhoto.png') }}" width="100px">
            </td>
            <td>
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
                {{ $item->category_name }}
            </td>
            <td>
                {{ $item->supplier_name }}
            </td>
            <td>
                <button class="btn btn-sm">
                    <a href=""><i class="bi bi-pencil" style="color:blue"></i></a>
                </button>
            </td>
            <td>
{{--                <form action="" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit" class="btn btn-sm delete-btn">--}}
{{--                        <i class="bi bi-trash3-fill" style="color:red"></i>--}}
{{--                    </button>--}}
{{--                </form>--}}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>


@endsection
