let turnosQueue = [];

// Función para cargar los turnos desde el archivo PHP
function loadTurnos() {
    fetch('../../../Backend/php/gets/getShifts.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                // Agregar todos los turnos a la cola de turnos
                turnosQueue = data.slice(0, 6); // Obtener hasta 6 turnos, si están disponibles
            } else {
                // No hay turnos disponibles
                turnosQueue = [];
            }

            // Actualizar la tabla con los turnos
            updateTable();
        })
        .catch(error => console.error('Error al cargar los turnos:', error));
}

// Función para actualizar la tabla con los turnos
function updateTable() {
    const tableBody = document.getElementById('shifts-table-body');
    tableBody.innerHTML = '';  // Limpiar cualquier contenido existente, excepto los encabezados

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

// Función para iniciar la carga de turnos cada 2 segundos
function startAutoReload() {
    loadTurnos(); // Cargar inmediatamente al inicio
    setInterval(loadTurnos, 2000); // Recargar cada 2 segundos
}

// Iniciar la recarga automática cuando la página haya terminado de cargarse
document.addEventListener('DOMContentLoaded', startAutoReload);
