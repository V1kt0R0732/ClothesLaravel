@extends('admin.layouts.layout', ['title'=>$title])

@section('content')

<form action="{{ route($cName.'.store') }}" method="post">
    @csrf
    @include('admin.parts.form')
    <input type="submit" name="send" value="Додати">
</form>

@endsection
