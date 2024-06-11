<?php

session_start();

$email = $_POST["email"];
$pass = $_POST["pass"];

include('config/config_mysqli.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Inicialización del array de respuesta
$response = array('type' => "error", 'id_dependencia' => "");

// Usar prepared statements para prevenir inyección SQL
$sql = "SELECT * FROM tb_funcionario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña cifrada
    if (password_verify($pass, $row['contrasena'])) {
        $_SESSION['user_id'] = $row['cedula'];
        $_SESSION['user_name'] = $row['nombre'];
        $_SESSION['user_lastname'] = $row['apellido'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id_dependencia'] = $row['id_dependencia'];
        $response['id_dependencia'] = $row['id_dependencia'];
        $response['dependencia'] = $row['id_dependencia'];
        $response['type'] = "success";

        // Insertar un registro en la tabla login_logs
        $log_sql = "INSERT INTO login_logs (user_id, id_dependencia) VALUES (?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("ss", $row['cedula'], $row['id_dependencia']);
        $log_stmt->execute();
        $log_stmt->close();

    } else {
        $response['type'] = "wrongPassword";
    }
} else {
    $response['type'] = "noEmail";
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>