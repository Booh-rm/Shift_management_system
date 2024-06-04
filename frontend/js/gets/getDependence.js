fetch('../../../Backend/php/gets/getDependence.php')
    .then(response => response.json())
    .then(data => {
        const dependenceSelect = document.getElementById('dependence');

        // Elimina las opciones existentes (excepto la primera)
        while (dependenceSelect.length > 1) {
            dependenceSelect.remove(1);
        }

        // Añade nuevas opciones con los nombres de las dependencias
        data.forEach(item => {
            const option = document.createElement('option');
            option.textContent = `${item.codigo} - ${item.descripcion}`;
            option.value = item.codigo;
            dependenceSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error al obtener las descripciones de las dependencias:', error);
    });

document.getElementById('dependence').addEventListener('change', function () {
});
