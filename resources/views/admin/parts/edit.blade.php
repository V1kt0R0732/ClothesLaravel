@extends('admin.layouts.layout', ['title'=>'Оновлення категорії','title2'=>'Зміна назви категорії'])

@section('content')


    <form action="{{ route('cat.update',['cat'=>$category->category_id]) }}" method="post">
        @csrf
        @method('PATCH')
        <h5>Назва Категорії</h5>
        <input type="text" name="category" value="{{ $category->category_name }}">
        <input type="submit" name="send" value="Оновити">
    </form>

@endsection
