<?php

include('../config/config_mysqli.php');

session_start();

$user_id = $_SESSION['user_id'];
$email = $_POST["email"];

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$response = array('type' => "success", 'nombre' => "-");

$sql = "SELECT * FROM tb_funcionario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

$response['user_name'] = $row['nombre'];

echo json_encode($response);

$conn->close();
?>
