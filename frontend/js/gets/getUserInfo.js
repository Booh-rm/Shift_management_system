window.onload = function () {
    $.post("../../../Backend/php/gets/getUserInfo.php", function (data) {
        var obj = JSON.parse(data);
        if (obj.type === 'success') {
            document.getElementById("userName").innerText = obj.user_name + ' ' + obj.user_lastname;
            document.getElementById("dependencia").innerText = " " + obj.dependencia;
        } else {
            console.error("Error: " + obj.message);
            // Redirige a la página de inicio de sesión si no está logeado
            window.location.href = "../../UI/users/users.html";
        }
    });
};

function loadDependenciaTurnos() {
    fetch('../../../Backend/php/gets/getShiftsA.php')
        .then(response => response.json())
        .then(data => {
            const verTurnoSpan = document.getElementById('turnoInfo');
            const shiftsTableBody = document.getElementById('shifts-table-body');
            const shiftheaderA = document.getElementById('verTurno');
            const shiftheaderB = document.getElementById('verCaja');
            // Limpiar cualquier contenido existente
            verTurnoSpan.innerHTML = '';
            shiftsTableBody.innerHTML = ''; // Limpiar la tabla de turnos
            shiftheaderA.innerHTML = '';
            shiftheaderB.innerHTML = '';

            if (data.length > 0) {
                const primerTurno = data[0];

                // Mostrar el primer turno en el encabezado
                document.getElementById('verTurno').textContent = primerTurno.id_turno;
                document.getElementById('verCaja').textContent = primerTurno.descripcion;

                // Crear el texto con la información del primer turno
                const turnoText = document.createTextNode(primerTurno.id_turno + ":\n " + "Atendiendo a usuario " + primerTurno.nombre_usuario + ", con numero de identificación: " + primerTurno.id_usuario);

                // Agregar el texto al elemento span
                verTurnoSpan.appendChild(turnoText);

                // Limpiar la cola de turnos
                turnosQueue = [];

                // Agregar los siguientes turnos a la cola de turnos
                for (let i = 1; i < Math.min(data.length, 6); i++) {
                    turnosQueue.push(data[i]);
                }

                // Actualizar la tabla con los turnos en la cola
                updateTable();
                console.log('Tabla actualizada en la vista 1');
                document.dispatchEvent(new Event('tablaActualizada'));

            } else {
                const noTurnoRow = document.createElement('tr');
                const noTurnoCell = document.createElement('td');
                noTurnoCell.textContent = 'No hay turnos disponibles para esta dependencia';
                noTurnoCell.colSpan = 3;
                noTurnoRow.appendChild(noTurnoCell);
                shiftsTableBody.appendChild(noTurnoRow);
            }
        })
        .catch(error => console.error('Error al cargar los turnos de la dependencia:', error));
}

// Cargar los turnos relacionados con la dependencia del funcionario
document.addEventListener('DOMContentLoaded', loadDependenciaTurnos);

// Función para actualizar la tabla con los siguientes 5 turnos
function updateTable() {
    const tableBody = document.getElementById('shifts-table-body');
    tableBody.innerHTML = '';  // Limpiar cualquier contenido existente

    turnosQueue.forEach(turno => {
        const row = document.createElement('tr');
        const turnoCell = document.createElement('td');
        turnoCell.textContent = turno.id_turno;

        row.appendChild(turnoCell);

        tableBody.appendChild(row);
    });

    if (turnosQueue.length === 0) {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.textContent = 'No hay turnos disponibles';
        cell.colSpan = 3;
        row.appendChild(cell);
        tableBody.appendChild(row);
    }
}