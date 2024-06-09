// Función para validar contraseñas y registrar un usuario
function validateAndRegister() {
    var password = document.getElementById("passwordregister").value;
    var confirmPassword = document.getElementById("passwordregisterc").value;

    // Verificar si las contraseñas coinciden
    if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden. Por favor, verifica.");
        // Prevenir el envío del formulario
        return false;
    }

    // Si las contraseñas coinciden, llamar a la función de registro
    register();
    // Prevenir el envío del formulario para manejarlo con AJAX
    return false;
}

// Función para registrar un usuario
function register() {
    var dni = document.getElementById("dni").value;
    var name = document.getElementById("name").value;
    var lastname = document.getElementById("lastname").value;
    var email = document.getElementById("emailregister").value;
    var pass = document.getElementById("passwordregister").value;
    var dependence = document.getElementById("dependence").value;

    // Variable para verificar si el formulario está listo para enviar
    var ready = true;

    // Si el formulario está listo para enviar, realiza una petición POST con los datos del registro
    if (ready) {
        $.post("../../../Backend/php/registers/registerUsers.php", {
            dni: dni,
            name: name,
            lastname: lastname,
            email: email,
            pass: pass,
            dependence: dependence
        },
            function (data) {
                // Procesa la respuesta de la petición
                var obj = JSON.parse(data);
                var tip = document.getElementById("tipText");


                if (obj.type == '1') {
                    alert("Registro satisfactorio!");
                }
                else if (obj.type == 'noEmail') {
                    alert("El correo ya encuentra registrado.");
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
    document.getElementById("dni").value = "";
    document.getElementById("name").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("emailregister").value = "";
    document.getElementById("passwordregister").value = "";
    document.getElementById("passwordregistec").value = "";
}