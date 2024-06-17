<?php
$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Consulta para truncar la tabla tb_turno
$truncateTurnoQuery = "TRUNCATE TABLE tb_turno";
if (mysqli_query($conn, $truncateTurnoQuery)) {
    echo "Tabla tb_turno truncada correctamente.<br>";
} else {
    echo "Error al truncar la tabla tb_turno: " . mysqli_error($conn) . "<br>";
}

// Consulta para truncar la tabla tb_turno_atendido
$truncateTurnoAtendidoQuery = "TRUNCATE TABLE tb_turno_atendido";
if (mysqli_query($conn, $truncateTurnoAtendidoQuery)) {
    echo "Tabla tb_turno_atendido truncada correctamente.<br>";
} else {
    echo "Error al truncar la tabla tb_turno_atendido: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>
