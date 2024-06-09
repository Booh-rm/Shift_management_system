let fieldsAdded = false;

document.getElementById('addFieldsBtn').addEventListener('click', function () {
    // Obtener el valor del DNI ingresado por el usuario
    var dni = document.getElementById('dni').value;

    // Realizar una solicitud AJAX para verificar si el DNI está en la base de datos
    $.ajax({
        url: '../../../Backend/php/gets/getClient.php',
        method: 'POST',
        data: { dni: dni }, // Envía el DNI al servidor
        success: function (response) {
 
            // Verifica si el DNI existe en la base de datos y la dependencia es válida
            if (response === 'existe') {
                // Obtenemos el índice del elemento seleccionado en el select
                var selectedIndex = document.getElementById('dependencia').selectedIndex;

                // Verificamos si se ha seleccionado el primer elemento del select (índice 0)
                if (selectedIndex === 0) {
                    // Si la dependencia no es válida, muestra una alerta
                    alert('Por favor, seleccione una dependencia válida.');
                    // Salir de la función para evitar que se muestren las opciones adicionales
                    return;
                } else {
                    // Si el DNI existe en la base de datos y la dependencia es válida, muestra la ventana modal
                    
                    obtenerNombreUsuario();
                    
                    // var modal = document.getElementById('turnoModal');
                    // modal.style.display = "block";
                }
            } else {
                // Si el DNI no existe en la base de datos, verifica si los campos adicionales ya se han agregado
                if (!fieldsAdded) {
                    // Si los campos adicionales no se han agregado, agrégalos
                    agregarCamposAdicionales();
                } else {
                    // Si los campos adicionales ya se han agregado, envía el formulario y registra el cliente
                    registerClient();
                }
            }
        }
    });
});

function agregarCamposAdicionales() {
    // Crear el contenedor adicional
    var additionalFields = document.getElementById('additionalFields');

    // Crear el primer nuevo campo y su etiqueta
    var label1 = document.createElement('label');
    label1.setAttribute('for', 'name');
    label1.textContent = 'Nombre';

    var name = document.createElement('input');
    name.type = 'text';
    name.id = 'name';
    name.name = 'name';
    name.placeholder = 'Tu nombre...';
    name.required = true;

    var label2 = document.createElement('label');
    label2.setAttribute('for', 'lastName');
    label2.textContent = 'Apellido';

    var lastName = document.createElement('input');
    lastName.type = 'text';
    lastName.id = 'lastName';
    lastName.name = 'lastName';
    lastName.placeholder = 'Tu apellido...';
    lastName.required = true;

    var label3 = document.createElement('label');
    label3.setAttribute('for', 'phone');
    label3.textContent = 'Teléfono';

    var phone = document.createElement('input');
    phone.type = 'text';
    phone.id = 'phone';
    phone.name = 'phone';
    phone.placeholder = 'Tu número de teléfono...';
    phone.required = true;

    var label4 = document.createElement('label');
    label4.setAttribute('for', 'email');
    label4.textContent = 'Correo electrónico';

    var email = document.createElement('input');
    email.type = 'email';
    email.id = 'email';
    email.name = 'email';
    email.placeholder = 'Tu email...';
    email.required = true;

    // Añadir las etiquetas y los campos al contenedor
    additionalFields.appendChild(label1);
    additionalFields.appendChild(name);
    additionalFields.appendChild(document.createElement('br'));
    additionalFields.appendChild(label2);
    additionalFields.appendChild(lastName);
    additionalFields.appendChild(document.createElement('br'));
    additionalFields.appendChild(label3);
    additionalFields.appendChild(phone);
    additionalFields.appendChild(document.createElement('br'));
    additionalFields.appendChild(label4);
    additionalFields.appendChild(email);
    additionalFields.appendChild(document.createElement('br'));

    // Marcar que los campos ya han sido agregados
    fieldsAdded = true;
}

function registerClient() {
    var name = document.getElementById('name').value;
    var lastName = document.getElementById('lastName').value;
    var phone = document.getElementById('phone').value;
    var email = document.getElementById('email').value;
    var dni = document.getElementById('dni').value;
    var dependencia = document.getElementById('dependencia').value;

    // Verificar que todos los campos están completos y que la dependencia es válida
    if (name && lastName && phone && email && dni && dependencia !== '') {
        $.ajax({
            url: '../../../Backend/php/registers/registerClients.php',
            method: 'POST',
            data: {
                dni: dni,
                name: name,
                lastName: lastName,
                phone: phone,
                email: email,
                dependencia: dependencia
            },
            success: function (response) {
                //línea para ver la respuesta del servidor
                console.log('Server response:', response); 
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.type === 1) {
                        obtenerNombreUsuario();
                        // var modal = document.getElementById('turnoModal');
                        // modal.style.display = "block";
                    } else {
                        alert('Hubo un error al registrar el cliente: ' + jsonResponse.message);
                    }
                } catch (e) {
                    alert('Hubo un error al procesar la respuesta del servidor. Por favor, inténtelo nuevamente.');
                    // línea para ver el error en la consola
                    console.error('Error parsing JSON response:', e); 
                }
            },
            error: function (xhr, status, error) {
                alert('Hubo un error con la solicitud AJAX. Por favor, inténtelo nuevamente.');
                // línea para ver el error en la consola
                console.error('AJAX error:', status, error); 
            }
        });
    } else {
        alert('Por favor, complete todos los campos y seleccione una dependencia válida.');
    }
}

// Obtener el elemento de cierre de la ventana modal
var span = document.getElementsByClassName('close')[0];

// Cuando el usuario hace clic en el (x), cerrar la ventana modal
span.onclick = function () {
    var modal = document.getElementById('turnoModal');
    modal.style.display = "none";
    // Recarga la página
    window.location.reload();
}

// Cuando el usuario hace clic fuera de la ventana modal, cerrarla
window.onclick = function (event) {
    var modal = document.getElementById('turnoModal');
    if (event.target == modal) {
        modal.style.display = "none";

        // Recarga la página
        window.location.reload();
    }
}

document.getElementById('closeBtn').addEventListener('click', function () {
    // Cierra el modal
    var modal = document.getElementById('turnoModal');
    modal.style.display = "none";

    // Recarga la página
    window.location.reload();
});

function obtenerNombreUsuario() {
    var dni = document.getElementById('dni').value;
    
    // Realizar una solicitud AJAX usando jQuery
    $.ajax({
        url: '../../../Backend/php/gets/getClientInfo.php',
        method: 'POST',
        data: { dni: dni }, // Enviar el DNI al servidor
        success: function(nombreApellidoUsuario) {
            console.log(nombreApellidoUsuario);
            mostrarModalConUsuario(nombreApellidoUsuario);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function mostrarModalConUsuario(nombreApellidoUsuario) {
    // Separar el nombre y el apellido del usuario
    var nombreApellidoArray = nombreApellidoUsuario.split(' ');
    var nombreUsuario = nombreApellidoArray[0];
    var apellidoUsuario = nombreApellidoArray[1];

    // Agregar el nombre y apellido del usuario al contenido del modal
    var modalContent = document.querySelector('.modal-content');
    var turnoP = modalContent.querySelector('.turno');
    turnoP.innerHTML = "Usuario: " + nombreUsuario + " " + apellidoUsuario + "<br>Su turno asignado es:<br>";

    // Mostrar el modal
    var modal = document.getElementById('turnoModal');
    modal.style.display = "block";
}
