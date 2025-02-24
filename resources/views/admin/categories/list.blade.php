@extends('admin.layouts.layout', ['title'=>'Список Категорій','title2'=>'Управління категоріями'])

@section('content')
    @if($categories->IsNotEmpty())
    <table class="table">
        <thead>
        <tr>
            <th class="id">
                Id
            </th>
            <th>
                Назва Категорії
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
@foreach($categories as $category)
        <tr>
            <td>
                {{ $category->category_id }}
            </td>
            <td>
                {{ $category->category_name }}
            </td>
            <td>
                <a href="{{ route('cat.edit', ['cat'=>$category->category_id]) }}"><i class="fa-solid fa-pencil" style="color: blue"></i></a>
            </td>
            <td>
                <form action="{{ route('cat.destroy', $category->category_id) }}" method="POST" class="delete-form"  onsubmit="if(confirm('Ви дійсно хочите видалити товар')){return true}else{return false}">
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
        <h3>Категорії відсутні</h3>
@endif
@endsection

