var email;
var username;

// Evento de carga de la ventana
window.onload = function () {
    // Obtiene el email almacenado en las cookies
    email = getCookie("email");
    // Redirecciona a la página de inicio de sesión si no hay email almacenado
    if(email == "") {
        window.location.href = "../../UI/users/users.html";
    }
    // Realiza una solicitud AJAX para obtener información del usuario
    else {
        $.post("../../../Backend/php/gets/getUser.php", {
            email : email
        },
        function (data) {
            var obj = JSON.parse(data);
            username = obj.nombre;
            document.getElementById("userName").innerText = "User : " + username;
        });
    }
};
 
function signOut() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;";
    }
    localStorage.clear();
    window.location = "../../UI/users/users.html";
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}