@extends('admin.layouts.layout', ['title'=>'Додавання категорії','title2'=>'Додавання категорії'])

@section('content')



<form action="{{ route('cat.store') }}" method="post">
    @csrf
    <h5>Назва Категорії</h5>
    <input type="text" name="category" placeholder="Худі">
    <input type="submit" name="send" value="Додати">
</form>

@endsection
