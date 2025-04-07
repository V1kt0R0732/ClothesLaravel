@extends('admin.layouts.layout', ['title'=>'Додавання одягу'])

@section('content')

    @if($clothes->IsNotEmpty())
        <table class="table">
            <thead>
            <tr>
                <th class="id">
                    Id
                </th>
                <th>
                    Назва
                </th>
                <th>
                    Категорія
                </th>
                <th>
                    Виробник
                </th>
                <th>
                    Ціна
                </th>
                <th>
                    На складі
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
