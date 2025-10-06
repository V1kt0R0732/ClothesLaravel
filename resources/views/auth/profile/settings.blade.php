@extends('auth.cabinet')


@section('module')

    <div class="card-body">
        <h5 class="mb-3">Налаштування</h5>
        <form>
            <div class="mb-3">
                <label class="form-label">Змінити фото профілю</label>
                <input type="file" name="avatar" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ваш Пароль</label>
                <input type="password" name="old_pass" class="form-control" placeholder="Введіть поточний пароль">
            </div>

            <div class="mb-3">
                <label class="form-label">Новий пароль</label>
                <input type="password" name="new_pass" class="form-control" placeholder="Введіть новий пароль">
            </div>

            <div class="mb-3">
                <label class="form-label">Підтвердження пароля</label>
                <input type="password" name="pass" class="form-control" placeholder="Повторіть новий пароль">
            </div>

            <button type="submit" class="btn btn-primary">Зберегти зміни</button>
        </form>
    </div>


@endsection
