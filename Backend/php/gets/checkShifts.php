<?php

include ('../config/config_mysqli.php');

// Verificar si se ha enviado un DNI
if (isset($_POST['dni'])) {

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el DNI del usuario desde la solicitud AJAX
    $dni = $_POST['dni'];

    // Consulta SQL para verificar si el usuario ya tiene un turno asignado
    $sql = "SELECT * FROM tb_turno WHERE id_usuario = '$dni'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // El usuario ya tiene un turno asignado
        echo 'existe';
    } else {
        // El usuario no tiene un turno asignado
        echo 'no_existe';
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se proporciona un DNI en la solicitud, devuelve un mensaje de error
    echo 'error';
}
?>