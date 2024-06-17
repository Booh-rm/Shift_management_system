let turnosQueue = [];

// Función para cargar los turnos desde el archivo PHP
function loadTurnos() {
    // console.log('Cargando turnos a las', new Date().toLocaleTimeString());
    fetch('../../../Backend/php/gets/getShifts.php')
        .then(response => response.json())
        .then(data => {

            if (data.length > 0) {
                // Dividir los turnos en dos grupos: primer turno y los siguientes 5 turnos
                const primerTurno = data.shift(); // Extraer el primer turno
                const siguientesTurnos = data.slice(0, 5); // Obtener los siguientes 5 turnos

                // Mostrar el primer turno en el encabezado
                document.getElementById('verTurno').textContent = primerTurno.id_turno;
                document.getElementById('verCaja').textContent = primerTurno.descripcion;

                // Agregar los siguientes 5 turnos a la cola de turnos
                turnosQueue = siguientesTurnos;
            } else {
                // No hay turnos disponibles
                document.getElementById('verTurno').textContent = '';
                document.getElementById('verCaja').textContent = '';
                turnosQueue = [];
            }

            // Actualizar la tabla con los siguientes 5 turnos
            updateTable();
        })
        .catch(error => console.error('Error al cargar los turnos:', error));
}

// Función para actualizar la tabla con los siguientes 5 turnos
function updateTable() {
    // console.log('Actualizando tabla a las', new Date().toLocaleTimeString());
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

// Función para iniciar la carga de turnos cada 2 segundos
function startAutoReload() {
    loadTurnos(); // Cargar inmediatamente al inicio
    setInterval(loadTurnos, 1000); // Recargar cada 2 segundos
}

// Iniciar la recarga automática cuando la página haya terminado de cargarse
document.addEventListener('DOMContentLoaded', startAutoReload);