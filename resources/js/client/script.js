document.addEventListener('DOMContentLoaded', function () {
    let cartCount = 0;
    const cartCountElem = document.getElementById('cart-count');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            cartCount++;
            cartCountElem.textContent = cartCount;
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');

    if (priceRange && priceValue) {
        // Установить начальное значение
        priceValue.textContent = priceRange.value + '₴';

        // Обновлять значение при изменении ползунка
        priceRange.addEventListener('input', function() {
            priceValue.textContent = priceRange.value + '₴';
        });
    }
});
