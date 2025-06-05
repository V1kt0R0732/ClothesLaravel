<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вхід в систему</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            @if(session('success'))
                <div class="row justify-content-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 400px; width: 100%;">
                        <strong>Успіх!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @elseif(session('error'))
            <div class="row justify-content-center">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 400px; width: 100%;">
                    <strong>Помилка!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Вхід в систему</h3>
                    <form action="{{ route('admin.login') }}" method="post">
                        @csrf
                        @method("POST")
                        <div class="mb-3">
                            <label for="email" class="form-label">Електронна адреса</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Запам'ятати мене</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Увійти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
