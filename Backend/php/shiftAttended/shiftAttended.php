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

$id_turno = $_POST['id_turno'];
$fecha_atendido = date('Y-m-d');
$hora_atendido = date('H:i:s');

// Comenzar la transacción
mysqli_begin_transaction($conn);

try {
    // Obtener los datos del turno
    $sql = "SELECT * FROM tb_turno WHERE id_turno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_turno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $turno = $result->fetch_assoc();

        // Insertar el turno en tb_turno_atendido
        $sql = "INSERT INTO tb_turno_atendido (id_turno, id_usuario, id_consulta, id_funcionario, desc_turno, fecha, hora, fecha_atendido, hora_atendido)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sisssssss",
            $turno['id_turno'],
            $turno['id_usuario'],
            $turno['id_consulta'],
            $turno['id_funcionario'],
            $turno['desc_turno'],
            $turno['fecha'],
            $turno['hora'],
            $fecha_atendido,
            $hora_atendido
        );
        $stmt->execute();

        // Eliminar el turno de tb_turno
        $sql = "DELETE FROM tb_turno WHERE id_turno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_turno);
        $stmt->execute();

        // Confirmar la transacción
        mysqli_commit($conn);
        echo json_encode(['type' => 'success', 'message' => 'Turno atendido exitosamente']);
    } else {
        throw new Exception("Turno no encontrado");
    }
} catch (Exception $e) {
    // Revertir la transacción
    mysqli_rollback($conn);
    echo json_encode(['type' => 'error', 'message' => $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>
