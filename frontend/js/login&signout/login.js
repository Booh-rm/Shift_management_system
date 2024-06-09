function login() {
    // Obtiene valores de los campos de inicio de sesión
    var email = document.getElementById("emailLogin").value;
    var pass = document.getElementById("passwordlogin").value;

    // Variable para verificar si el formulario está listo para enviar
    var ready = true;

    if (ready) {
        $.post("../../../Backend/php/login.php", {
            email: email,
            pass: pass
        },
            function (data) {
                // Procesa la respuesta de la petición
                var obj = JSON.parse(data);
                var tip = document.getElementById("tipText");
                if (obj.type == 'success') {
                    // Verifica el tipo de usuario y redirige a la página correspondiente
                    if (obj.id_dependencia == '0') {
                        document.cookie = "email=" + email + "; path=../../UI/admin/admin.html";
                        window.location.href = "../../UI/admin/admin.html"; // Página para admin
                    } else {
                        document.cookie = "email=" + email + "; path=../../UI/users/usersInterface.html";
                        window.location.href = "../../UI/users/usersInterface.html"; // Página para asesor
                    }
                }
                else if (obj.type == 'wrongPassword') {
                    alert("Contraseña incorrecta.");
                }
                else if (obj.type == 'noEmail') {
                    alert("El correo no se encuentra registrado.");
                }
                else {
                    alert("Error al conectar a la base de datos.");
                }

                $('#myModal').modal('show');
            });
        // Llama a la función para limpiar los campos de entrada
        clearInput();
    }
}

// Función para limpiar los campos de entrada y restablecer estilos
function clearInput() {
    document.getElementById("emailLogin").value = "";
    document.getElementById("passwordlogin").value = "";
}