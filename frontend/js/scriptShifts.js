let fieldsAdded = false;

document.getElementById('addFieldsBtn').addEventListener('click', function () {
    if (fieldsAdded) {
        // Si los campos ya se han agregado, mostrar la ventana modal
        var modal = document.getElementById('turnoModal');
        modal.style.display = "block";
        return;
    }

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

    // Mover el botón de enviar debajo de los nuevos cuadros de texto
    additionalFields.appendChild(this);

    // Cambiar el tipo de botón a submit
    this.type = 'submit';

    // Marcar que los campos ya han sido agregados
    fieldsAdded = true;
});

// Intercepta el evento de envío del formulario
document.getElementById('turnoForm').addEventListener('submit', function (e) {
    // Evita que el formulario se envíe
    e.preventDefault();

    // Muestra el modal
    var modal = document.getElementById('turnoModal');
    modal.style.display = "block";
});

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
