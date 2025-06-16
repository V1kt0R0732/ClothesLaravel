@extends('admin.layouts.layout', ['title'=>'Профіль користувача'])

@section('content')



    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{route('admin.edit')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center mb-4">
                        <img src="{{Storage::url(Session('user.avatar'))}}" alt="Фото профілю" class="profile-pic mb-2">
                        <div>
                            <input class="form-control form-control-sm d-inline-block w-auto" type="file" name="avatar" id="photoUpload">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">ФІО</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{Session('user.name')}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Електронна адресса</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{Session('user.email')}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль для підтвердження особи</label>
                        <input type="password" name="old_password" class="form-control" id="password" placeholder="*****" required>
                    </div>


                    <div class="container mt-4">
                        <button type="button" class="btn btn-outline-primary" id="togglePasswordFields">
                            🔐 Змінити пароль
                        </button>

                        <input type="hidden" name="change_password" id="changePasswordFlag" value="0">

                        <div id="passwordFields" class="collapse-section mt-3">
                            <div class="mb-2">
                                <label for="newPassword" class="form-label">Новий пароль</label>
                                <input type="password" class="form-control" id="newPassword" name="new_password">
                            </div>
                            <div class="mb-2">
                                <label for="confirmPassword" class="form-label">Підтвердження пароля</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="role" class="form-label">Права доступу</label>
                        <select class="form-select" id="role" disabled>
                            <option selected>{{Session('user.permission')}}</option>

                        </select>
                        <div class="form-text">Змінити права може лише головний адміністратор.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
