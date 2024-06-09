<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['type' => 'error', 'message' => 'User not logged in']);
    exit();
}

$serverName = "localhost";
$userName = "root";
$password = "";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_id = $_SESSION['user_id'];
$dependencia_id = $_SESSION['id_dependencia'];

$response = [
    'type' => 'success',
    'user_name' => $_SESSION['user_name'],
    'user_lastname' => $_SESSION['user_lastname'],
    'email' => $_SESSION['email'],
    'dependencia' => $_SESSION['id_dependencia']
];

// Consulta para obtener la descripción de la dependencia
$sql = "SELECT descripcion FROM tb_tipo_consulta WHERE codigo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dependencia_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['dependencia'] = $row['descripcion'];
} else {
    $response['dependencia'] = 'No definida';
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
