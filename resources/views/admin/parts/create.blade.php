@extends('admin.layouts.layout', ['title'=>$title])

@section('content')



<form action="{{ route($cName.'.store') }}" method="post">
    @csrf
    <h5>{{ $text }}</h5>
    <input type="text" name="{{ $cName }}" placeholder="Текст">
    <input type="submit" name="send" value="Додати">
</form>

@endsection
