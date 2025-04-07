@extends('admin.layouts.layout', ['title'=>'Оновлення категорії','title2'=>'Зміна назви категорії'])

@section('content')


    <form action="{{ route($cName.'.update',[$cName=>$object->$id]) }}" method="post">
        @csrf
        @method('PATCH')
        @include('admin.parts.form')
    </form>

@endsection
