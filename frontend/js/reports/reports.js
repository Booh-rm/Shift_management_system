document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencia al botón
    const informeBtn = document.getElementById('informe-btn');

    // Agregar evento de clic al botón
    informeBtn.addEventListener('click', function() {
        // Realizar una solicitud al servidor para generar y descargar el PDF
        fetch('../../../Backend/php/reports/statistics.php', {
            method: 'POST',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob();
        })
        .then(blob => {
            // Crear un objeto URL para el blob
            const url = window.URL.createObjectURL(blob);

            // Crear un elemento <a> para descargar el PDF
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'reporte.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error al generar el informe:', error);
            alert('Error al generar el informe. Por favor, inténtalo de nuevo más tarde.');
        });
    });
});
