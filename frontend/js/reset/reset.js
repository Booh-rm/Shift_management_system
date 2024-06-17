document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencia al botón de reset
    const resetBtn = document.getElementById('reset-btn');

    // Agregar evento click al botón
    resetBtn.addEventListener('click', function() {
        // Confirmar con el usuario antes de ejecutar la acción
        if (confirm('¿Estás seguro de resetear el contador de turnos?')) {
            // Realizar la solicitud AJAX al archivo reset.php
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../Backend/php/reset/reset.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Éxito en la solicitud
                    console.log(xhr.responseText);
                    alert('Contador de turnos reseteado correctamente.');
                } else {
                    // Error en la solicitud
                    console.error('Error en la solicitud:', xhr.statusText);
                    alert('Error al intentar resetear el contador de turnos.');
                }
            };
            xhr.onerror = function() {
                console.error('Error en la solicitud.');
                alert('Error al intentar resetear el contador de turnos.');
            };
            xhr.send();
        }
    });
});
