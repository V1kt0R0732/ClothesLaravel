@extends('admin.layouts.layout', ['title'=>'Управління користувачами'])

@section('content')

    @if($users->IsNotEmpty())

        <table class="table">
            <thead>
            <tr>
                <th class="id">
                    <a>Id</a>
                </th>
                <th>
                    <a>Фото</a>
                </th>
                <th>
                    <a>Ім`я</a>
                </th>
                <th>
                    <a>E-Mail</a>
                </th>
                <th>
                    <a>Роль</a>
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
            @foreach($users as $item)
{{--                                {{print_r($item)}}--}}
                <tr>
                    <td>
                        {{ $item->id }}
                    </td>
                    <td>
                        <img src="{{ Storage::url($item->avatar) }}" width="100px">
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->email }}
                    </td>
                    <td>
                        {{ $item->permission_name }}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm">
                            <a ><i class="bi bi-pencil" style="color:blue"></i></a>
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
