@extends('admin.layouts.layout', ['title'=>'Реєстрація нового користувача'])

@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Створити акаунт</h3>
                        <form action="{{ route('admin.register') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Повне ім’я</label>
                                <input type="text" name="name" class="form-control" id="fullName" placeholder="Іван Іванов" value="{{ old('name') ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Електронна пошта</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="••••••••">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Підтвердіть пароль</label>
                                <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="••••••••">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Роль користувача</label>
                                <select class="form-select" name="role" id="role">
                                    <option value="2">Admin</option>
                                    <option value="3">Moderator</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Зареєструватися</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
