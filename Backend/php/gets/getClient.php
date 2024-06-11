<?php

include('../config/config_mysqli.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$dni = $_POST["dni"];

$sql = "SELECT cedula FROM tb_usuario WHERE cedula = '$dni'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // El DNI existe en la base de datos
    echo "existe";
} else {
    // El DNI no existe en la base de datos
    echo "no_existe";
}

$conn->close();
?>
