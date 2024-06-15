<?php

// include('../config/config_mysqli.php');
$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Modificar la consulta SQL para excluir registros con codigo=0
$sql = "SELECT codigo, descripcion FROM tb_tipo_consulta WHERE codigo != '0';";
$result = $conn->query($sql);

// Array para almacenar las descripciones de las dependencias
$descriptionDp = array();

// Recorre los resultados de la consulta y añade las descripciones al array
while ($row = $result->fetch_assoc()) {
    $descriptionDp[] = [
        'codigo' => $row['codigo'],
        'descripcion' => $row['descripcion']
    ];
}

$conn->close();

echo json_encode($descriptionDp);

?>