<?php

// include('../config/config_mysqli.php');

$dni = $_POST["dni"];
$name = $_POST["name"];
$lastname = $_POST["lastName"];
$phone = $_POST["phone"];
$email = $_POST["email"];

$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    echo json_encode(array('type' => 0, 'message' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

$sql = "INSERT INTO tb_usuario (cedula, nombre, apellido, telefono, email) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $dni, $name, $lastname, $phone, $email);

if ($stmt->execute() === TRUE) {
    echo json_encode(array('type' => 1, 'message' => 'Cliente registrado correctamente'));
} else {
    echo json_encode(array('type' => 0, 'message' => 'Error: ' . $stmt->error));
}

$stmt->close();
mysqli_close($conn);
?>