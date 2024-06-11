<?php

include('config/config_mysqli.php');

$dni = $_POST["dni"];
$dependence = $_POST["dependence"];
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$pass = $_POST["pass"];

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cifrar la contraseña usando password_hash
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

$response = array('type' => 1, 'name' => $name);

// Usar prepared statements para prevenir inyección SQL
$sql = "INSERT INTO tb_funcionario (cedula, id_dependencia, nombre, apellido, email, contrasena) VALUES (?, ?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $dni, $dependence, $name, $lastname, $email, $hashedPass);

if ($stmt->execute() === TRUE) {
    echo json_encode($response);
} else {
    $response['type'] = 0;
    echo json_encode($response);
}

$stmt->close();
mysqli_close($conn);
?>
