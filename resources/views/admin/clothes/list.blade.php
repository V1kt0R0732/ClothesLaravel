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
                        <a href=""><i class="fa-solid fa-pencil" style="color: blue"></i></a>
                    </td>
                    <td>
                        <form action="" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm delete-btn">
                                <i class="fa-solid fa-trash" style="color:red"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>{{ $cName }} відсутні</h3>
    @endif

@endsection
