<?php

include('config/config_mysqli.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Conexion exitosa";

mysqli_close($conn);
?>