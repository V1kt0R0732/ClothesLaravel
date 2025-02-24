document.addEventListener("DOMContentLoaded", function() {
    // Переключение бокового меню
    document.getElementById("menu-toggle").addEventListener("click", function() {
        let sidebar = document.getElementById("sidebar");
        let mainContent = document.querySelector("main");

        if (sidebar.style.left === "0px" || sidebar.style.left === "") {
            sidebar.style.left = "-250px";
            mainContent.style.marginLeft = "0";
        } else {
            sidebar.style.left = "0px";
            mainContent.style.marginLeft = "250px";
        }
    });


    document.querySelectorAll(".toggle-submenu").forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            let submenu = this.nextElementSibling;

            // Закрываем все остальные подменю
            // document.querySelectorAll(".submenu").forEach(menu => {
            //     if (menu !== submenu) {
            //         menu.classList.remove("open");
            //     }
            // });

            // Переключаем текущее подменю
            submenu.classList.toggle("open");
        });
    });


    // Кнопка скрытия бокового меню
    document.getElementById("hide-menu").addEventListener("click", function() {
        let sidebar = document.getElementById("sidebar");
        let mainContent = document.querySelector("main");

        sidebar.style.left = "-250px";
        mainContent.style.marginLeft = "0";
    });

    // Логика для выпадающего меню пользователя
    document.getElementById("userDropdown").addEventListener("click", function(event) {
        event.stopPropagation();
        let menu = document.getElementById("userMenu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    // Закрытие выпадающего меню при клике вне
    document.addEventListener("click", function() {
        document.getElementById("userMenu").style.display = "none";
    });
});
