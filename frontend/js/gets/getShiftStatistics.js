// Función para cargar las estadísticas de turnos desde el archivo PHP
function loadShiftStatistics() {
    fetch('../../../Backend/php/gets/getShiftStatistics.php')
        .then(response => response.json())
        .then(data => {
            // Actualizar la tabla con las estadísticas
            updateStatisticsTable(data);
        })
        .catch(error => console.error('Error al cargar las estadísticas de turnos:', error));
}

// Función para actualizar la tabla con las estadísticas
function updateStatisticsTable(data) {
    const tableBody = document.getElementById('shifts-table-body2');
    tableBody.innerHTML = '';  // Limpiar cualquier contenido existente

    const row = document.createElement('tr');

    // Celda para el total de turnos
    const totalTurnosCell = document.createElement('td');
    totalTurnosCell.textContent = data.total_turnos;
    row.appendChild(totalTurnosCell);

    // Celda para la dependencia más solicitada
    const depMasSolicitadaCell = document.createElement('td');
    depMasSolicitadaCell.colSpan = 2;
    depMasSolicitadaCell.textContent = data.dependencias_mas_solicitadas.join(', ');
    row.appendChild(depMasSolicitadaCell);

    // Celda para la dependencia menos solicitada
    const depMenosSolicitadaCell = document.createElement('td');
    depMenosSolicitadaCell.colSpan = 2;
    depMenosSolicitadaCell.textContent = data.dependencias_menos_solicitadas.join(', ');
    row.appendChild(depMenosSolicitadaCell);

    tableBody.appendChild(row);
}

// Función para iniciar la carga de turnos cada 2 segundos
function startAutoReload() {
    loadShiftStatistics(); // Cargar inmediatamente al inicio
    setInterval(loadShiftStatistics, 2000); // Recargar cada 2 segundos
}

// Iniciar la recarga automática cuando la página haya terminado de cargarse
document.addEventListener('DOMContentLoaded', startAutoReload);