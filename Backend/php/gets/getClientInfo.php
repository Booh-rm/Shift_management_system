<?php

$dni = $_POST['dni'];

$serverName = "localhost";
$userName = "root";
$password = "";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Consultar la base de datos para obtener el nombre y apellido del usuario correspondiente al DNI
$sql = "SELECT nombre, apellido FROM tb_usuario WHERE cedula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si se encontró un usuario con el DNI proporcionado, enviar el nombre y apellido del usuario al cliente
    $row = $result->fetch_assoc();
    $response = array(
        'nombre' => $row["nombre"],
        'apellido' => $row["apellido"]
    );
    // Envía los datos directamente como un array
    echo json_encode($response);
} else {
    // Si no se encontró un usuario con el DNI proporcionado, devolver un mensaje de error o un valor predeterminado
    echo json_encode(array('error' => 'Usuario no encontrado'));
}

$stmt->close();
$conn->close();
?>
