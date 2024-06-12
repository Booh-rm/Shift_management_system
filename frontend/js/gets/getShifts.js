let turnosQueue = [];
// document.addEventListener('DOMContentLoaded', function() {
//     loadTurnos();
//     console.log('Escuchando evento de tabla actualizada en la vista 2');
//     document.addEventListener('tablaActualizada', loadTurnos);
// });
// Función para cargar los turnos desde el archivo PHP
function loadTurnos() {
    fetch('../../../Backend/php/gets/getShifts.php')
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

            // Dividir los turnos en dos grupos: primer turno y los siguientes 5 turnos
            const primerTurno = data.shift(); // Extraer el primer turno
            const siguientesTurnos = data.slice(0, 5); // Obtener los siguientes 5 turnos

            // Mostrar el primer turno en el encabezado
            document.getElementById('verTurno').textContent = primerTurno.id_turno;
            document.getElementById('verCaja').textContent = primerTurno.descripcion;

            // Agregar los siguientes 5 turnos a la cola de turnos
            turnosQueue = siguientesTurnos;

            // Actualizar la tabla con los siguientes 5 turnos
            updateTable();
        })
        .catch(error => console.error('Error al cargar los turnos:', error));
}

// Función para actualizar la tabla con los siguientes 5 turnos
function updateTable() {
    const tableBody = document.getElementById('shifts-table-body');
    tableBody.innerHTML = '';  // Limpiar cualquier contenido existente

    turnosQueue.forEach(turno => {
        const row = document.createElement('tr');
        const turnoCell = document.createElement('td');
        const dependenciaCell = document.createElement('td');
        turnoCell.textContent = turno.id_turno;
        dependenciaCell.textContent = turno.descripcion;
        dependenciaCell.colSpan = 2;

        row.appendChild(turnoCell);
        row.appendChild(dependenciaCell);

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

// Cargar los turnos cuando la página haya terminado de cargarse
document.addEventListener('DOMContentLoaded', loadTurnos);
