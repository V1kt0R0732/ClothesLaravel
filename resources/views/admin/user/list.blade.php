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
                    @if($item->id == Session('user.id'))
                        <td>
                            {{$item->permission_name}}
                        </td>
                        <td>
                            Неможливо змінити
                        </td>
                        <td>
                            Неможливо видалити
                        </td>
                    @else
                    <form action="{{route('admin.changeId')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <td>
                            <select class="form-select" name="perm">
                                @foreach($permissions as $perm)
                                    <option @if($item->permission_name == $perm->name) selected @endif value="{{$perm->permission_id}}">{{$perm->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-success">
                                <a>Змінити</a>
                            </button>
                        </td>
                    </form>
                    <td>
                        <form action="{{route('admin.delete', $item->id)}}" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm delete-btn btn-danger">
                                Видалити
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>Загальна таблиця одягу відсутня</h3>
    @endif

@endsection
