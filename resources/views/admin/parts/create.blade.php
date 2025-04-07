@extends('admin.layouts.layout', ['title'=>$title])

@section('content')

<form action="{{ route($cName.'.store') }}" method="post">
    @csrf
    @include('admin.parts.form')
</form>

@endsection
