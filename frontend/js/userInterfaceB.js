const iconBoxes = document.querySelectorAll(".icon-box");
const iconBoxBack = document.querySelectorAll(".icon-box-back");
const iconBoxContainers = document.querySelectorAll(".icon-container");
const closeBtns = document.querySelectorAll(".close-btn");
const maximizeBtns = document.querySelectorAll(".maximize-btn");
const body = document.querySelector("body");

iconBoxes.forEach((btn) => {
    btn.addEventListener("click", () => {
        let modal = btn.getAttribute("data-modal");
        document.getElementById(modal).style.display = "block";
        body.classList.add("prevent-background-scroll");
    });
});

closeBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        let modal = btn.closest(".popup");
        modal.style.display = "none";
        body.classList.remove("prevent-background-scroll");
        iconBoxContainers.forEach((container) => {
            container.style.display = "flex";
        });
    });
});

document.addEventListener("click", (e) => {
    if (e.target.classList.contains("popup")) {
        e.target.style.display = "none";
        body.classList.remove("prevent-background-scroll");
    }
});

maximizeBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        let modal = btn.closest(".popup");
        let container = modal.querySelector(".popup-container");
        let body = modal.querySelector(".popup-body");

        if (modal.classList.contains("maximized")) {
            container.style.width = "min(900px, 90%)";
            container.style.top = "45%";
            body.style.height = "70vh";
        } else {
            container.style.width = "100%";
            container.style.top = "50%";
            body.style.height = "90vh";
        }

        modal.classList.toggle("maximized");
        body.classList.toggle("prevent-scroll");
    });
});

// Seleccionar el botón con la clase 'logOut-btn'
const logOutBtn = document.querySelector('.exit-btn');

// Añadir el eventListener para redirigir al hacer clic
logOutBtn.addEventListener('click', () => {
    fetch('../../../Backend/php/logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 1) {
            // Redirigir a la página de inicio de sesión después de cerrar sesión correctamente
            window.location.href = '/Shift_management_system/frontend/UI/users/users.html';
        } else {
            console.error('Error al cerrar sesión:', data.message);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud de cierre de sesión:', error);
    });
});