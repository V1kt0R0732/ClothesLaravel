@extends('admin.layouts.layout', ['title'=>$title])

@section('content')
    @if($objects->IsNotEmpty())
    <table class="table">
        <thead>
        <tr>
            <th class="id">
                Id
            </th>
            <th>
                Назва
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
@foreach($objects as $item)
        <tr>
            <td>
                {{ $item->$id }}
            </td>
            <td>
                {{ $item->$name }}
            </td>
            <td>
                <a href="{{ route($cName.'.edit', [$cName=>$item->$id]) }}"><i class="fa-solid fa-pencil" style="color: blue"></i></a>
            </td>
            <td>
                <form action="{{ route($cName.'.destroy', $item->$id) }}" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
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

