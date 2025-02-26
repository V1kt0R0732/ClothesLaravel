@extends('admin.layouts.layout', ['title'=>'Оновлення категорії','title2'=>'Зміна назви категорії'])

@section('content')


    <form action="{{ route($cName.'.update',[$cName=>$object->$id]) }}" method="post">
        @csrf
        @method('PATCH')
        <h5>{{ $text }}</h5>
        <input type="text" name="{{ $cName }}" value="{{ $object->$name }}">
        <input type="submit" name="send" value="Оновити">
    </form>

@endsection
