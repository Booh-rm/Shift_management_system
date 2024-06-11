<?php

include('../config/config_mysqli.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['type' => 'error', 'message' => 'User not logged in']);
    exit();
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$dependencia_id = $_SESSION['id_dependencia'];

// Consulta para obtener los turnos relacionados con la dependencia del funcionario
$sql = "SELECT t.id_turno, u.nombre, u.apellido, u.cedula, tc.descripcion
        FROM tb_turno t JOIN tb_tipo_consulta tc ON t.id_consulta = tc.codigo
        INNER JOIN tb_usuario u ON t.id_usuario = u.cedula 
        WHERE t.id_consulta = ? ORDER BY t.id_turno ASC ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dependencia_id);
$stmt->execute();
$result = $stmt->get_result();

$turnos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $turnos[] = [
            'id_turno' => $row['id_turno'],
            'nombre_usuario' => $row['nombre'] . " " . $row['apellido'],
            'id_usuario' => $row['cedula'],
            'descripcion' => $row['descripcion']
        ];
    }
}

echo json_encode($turnos);

$stmt->close();
$conn->close();
?>