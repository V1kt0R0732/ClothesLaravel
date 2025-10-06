@extends('auth.cabinet')

@section('module')


    <div class="card-header bg-white">
        <h5 class="mb-0">Панель користувача</h5>
    </div>
    <div class="card-body">

        <!-- Наприклад: дані профілю -->
        <form action="{{route('cabinet.edit')}}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">Ім’я</label>
                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
            </div>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>


@endsection
