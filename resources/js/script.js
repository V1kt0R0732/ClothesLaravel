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

    // Фото




    // document.querySelectorAll(".selectable-photo").forEach(function (card) {
    //     card.addEventListener("click", function () {
    //         document.querySelectorAll(".selectable-photo").forEach(function (el) {
    //             el.classList.remove("selected");
    //             el.querySelector('input[type="radio"]').checked = false;
    //         });
    //
    //         card.classList.add("selected");
    //         card.querySelector('input[type="radio"]').checked = true;
    //     });
    // });

    // Функція для обирання форми

    const mainPhotoInput = document.getElementById("mainPhotoInput");

    document.querySelectorAll(".selectable-photo").forEach(function (card) {
        card.addEventListener("click", function () {
            // Знімаємо вибір з усіх карток
            document.querySelectorAll(".selectable-photo").forEach(function (el) {
                el.classList.remove("selected");
            });

            // Позначаємо поточну картку як вибрану
            card.classList.add("selected");

            // Знаходимо значення ID (можна через data-id або атрибут)
            const photoId = card.getAttribute("data-photo-id");
            if (mainPhotoInput) {
                mainPhotoInput.value = photoId;
            }
        });
    });



    // передача id для видалення товарів
    const mainStorageId = document.getElementById('mainStorageId')
    let storageIdArrayMain = [];

    document.querySelectorAll(".storage-select").forEach(function (card) {
        card.addEventListener("click", function () {

            let storageId = card.getAttribute("data-storage-id");

            let check = false;

            for (let i = 0; i < storageIdArrayMain.length; i++) {
                if (storageIdArrayMain[i] === storageId){

                    document.querySelector(".storage-item-"+storageId).classList.remove("storage-selected");

                    check = true;
                    storageIdArrayMain.splice(i, 1);

                    break;
                }
            }

            if(!check){
                storageIdArrayMain.push(storageId);
                document.querySelector(".storage-item-"+storageId).classList.add("storage-selected");
            }

            if(mainStorageId){
                mainStorageId.value = storageIdArrayMain;
            }

        });
    });



});

