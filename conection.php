<?php

$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "Shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Conexion exitosa";

mysqli_close($conn);
?>