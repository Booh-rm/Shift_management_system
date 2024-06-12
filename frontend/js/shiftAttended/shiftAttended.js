document.addEventListener('DOMContentLoaded', loadDependenciaTurnos);

document.getElementById('atender-btn').addEventListener('click', function () {
    const turnoInfoSpan = document.getElementById('turnoInfo');
    const turnoId = turnoInfoSpan.textContent.split(":")[0].trim();

    if (turnoId) {
        fetch('../../../Backend/php/shiftAttended/shiftAttended.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_turno=${turnoId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'success') {
                    loadDependenciaTurnos(); // Volver a cargar los turnos después de atender uno
                    // Después de atender un turno
                    // document.dispatchEvent(new Event('turnoAtendido'));

                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('Error al atender el turno:', error));
    } else {
        console.error('No hay turno disponible para atender');
    }
});