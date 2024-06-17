window.onload = function () {
    $.post("../../../Backend/php/gets/getUserInfo.php", function (data) {
        var obj = JSON.parse(data);
        if (obj.type === 'success') {
            document.getElementById("userName").innerText = obj.user_name + ' ' + obj.user_lastname; 
        } else {
            console.error("Error: " + obj.message);
            // Redirige a la página de inicio de sesión si no está logeado
            window.location.href = "../../UI/users/users.html";
        }
    });
};
