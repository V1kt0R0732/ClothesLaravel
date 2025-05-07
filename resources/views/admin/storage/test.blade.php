<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Товар с фото и радиокнопками</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thumb-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumb-img.active {
            border-color: #fd7e14; /* Оранжевый — для активного */
        }

        .product-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Главное изображение -->
            <img src="https://via.placeholder.com/600x400" class="img-fluid product-img mb-3" id="mainImage" alt="Product">

            <!-- Превью -->
            <div class="d-flex gap-2">
                <img src="https://via.placeholder.com/100x100" class="thumb-img active" onclick="changeImage(this)">
                <img src="https://via.placeholder.com/100x100/ffaaaa" class="thumb-img" onclick="changeImage(this)">
                <img src="https://via.placeholder.com/100x100/aaffaa" class="thumb-img" onclick="changeImage(this)">
            </div>
        </div>

        <div class="col-md-6">
            <h2>Название товара</h2>
            <p>Описание товара с какими-то характеристиками. Очень красиво.</p>

            <!-- Радио кнопки -->
            <h5>Выберите вариант:</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="variant" id="variant1" checked>
                <label class="form-check-label" for="variant1">
                    Вариант 1
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="variant" id="variant2">
                <label class="form-check-label" for="variant2">
                    Вариант 2
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="variant" id="variant3">
                <label class="form-check-label" for="variant3">
                    Вариант 3
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(el) {
        document.getElementById('mainImage').src = el.src;
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
        el.classList.add('active');
    }
</script>

</body>
</html>
