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

// Consulta para obtener los turnos y las descripciones de las dependencias
$sql = "SELECT t.id_turno, tc.descripcion 
        FROM tb_turno t 
        JOIN tb_tipo_consulta tc ON t.id_consulta = tc.codigo";

$result = $conn->query($sql);

// Array para almacenar los turnos
$turnos = array();

// Recorre los resultados de la consulta y añade los turnos al array
while ($row = $result->fetch_assoc()) {
    $turnos[] = [
        'id_turno' => $row['id_turno'],
        'descripcion' => $row['descripcion']
    ];
}

$conn->close();

echo json_encode($turnos);

?>