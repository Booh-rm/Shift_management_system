fetch('../../../Backend/php/gets/getActiveDependence.php')
    .then(response => response.json())
    .then(data => {
        const dependenceSelect = document.getElementById('dependencia');

        // Elimina las opciones existentes (excepto la primera)
        while (dependenceSelect.length > 1) {
            dependenceSelect.remove(1);
        }

        // Añade nuevas opciones con los nombres de las dependencias
        data.forEach(item => {
            const option = document.createElement('option');
            option.textContent = `${item.id_dependencia} - ${item.descripcion}`;
            option.value = item.id_dependencia;
            dependenceSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error al obtener las descripciones de las dependencias:', error);
    });

document.getElementById('dependencia').addEventListener('change', function () {
});
