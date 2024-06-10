<?php

require '../services/email/notificationsEmail.php';
require '../services/sms/notificationsSms.php';

// Configurar para manejar errores
ini_set('display_errors', 0);
error_reporting(E_ALL);

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    respondWithError("PHP error [$errno]: $errstr in $errfile on line $errline");
});

set_exception_handler(function($exception) {
    respondWithError("Uncaught exception: " . $exception->getMessage());
});

// Función para manejar errores y responder en JSON
function respondWithError($message) {
    echo json_encode(array('success' => false, 'error' => $message));
    exit;
}

try {
    $dni = $_POST['dni'];
    $idConsulta = $_POST['id_consulta'];
    $nombreUsuario = $_POST['nombre_usuario'];
    $apellidoUsuario = $_POST['apellido_usuario'];
    $dependencia = $_POST['dependencia'];

    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $database = "shift_management_system";

    $conn = mysqli_connect($serverName, $userName, $password, $database);

    if (!$conn) {
        respondWithError('Connection failed: ' . mysqli_connect_error());
    }

    // Obtener el siguiente ID de turno
    $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(id_turno, 'A', 1) AS UNSIGNED)) AS max_id 
            FROM tb_turno 
            WHERE id_consulta = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        respondWithError('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $idConsulta);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $nextId = $row['max_id'] ? $row['max_id'] + 1 : 1;
    $idTurno = str_pad($nextId, 3, '0', STR_PAD_LEFT) . $idConsulta;

    // Obtener el id_funcionario basado en la consulta
    $sql = "SELECT cedula FROM tb_funcionario WHERE id_dependencia = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        respondWithError('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $idConsulta);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idFuncionario = $row['cedula'];

    // Obtener el nombre y apellido del funcionario
    $sql = "SELECT nombre, apellido FROM tb_funcionario WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        respondWithError('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $idFuncionario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $nombreFuncionario = $row['nombre'];
    $apellidoFuncionario = $row['apellido'];

    // Obtener el correo electrónico y teléfono del usuario
    $sql = "SELECT telefono, email FROM tb_usuario WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        respondWithError('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $phoneUsuario = $row['telefono'];
    $emailUsuario = $row['email'];

    // Insertar el turno en la base de datos
    $sql = "INSERT INTO tb_turno (id_turno, id_usuario, id_consulta, id_funcionario, desc_turno, fecha, hora)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        respondWithError('Prepare statement failed: ' . $conn->error);
    }
    $descTurno = "Apreciado cliente: " . $nombreUsuario . " " . $apellidoUsuario . ',' .
                " su turno corresponde al: " . $idTurno . ", en la dependencia: " . $dependencia .
                ", atendido por: " . $nombreFuncionario . " " . $apellidoFuncionario . ',' .
                "\n fecha: " . date('Y-m-d') . " hora: " . date('H:i:s');
    $stmt->bind_param("sssss", $idTurno, $dni, $idConsulta, $idFuncionario, $descTurno);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        // Enviar correo electrónico con SendGrid
        try {
            // Enviar correo electrónico con SendGrid
            $emailStatus = sendEmail($emailUsuario, $nombreUsuario, $descTurno);
        } catch (Exception $e) {
            respondWithError("Error al enviar el correo electrónico: " . $e->getMessage());
        }

        // Enviar SMS con Twilio
        // $smsStatus = sendSMS($phoneUsuario, $descTurno);

        echo json_encode(array(
            'success' => true,
            'id_turno' => $idTurno,
            'desc_turno' => $descTurno
        ));
    } else {
        respondWithError('Error al registrar el turno.');
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    respondWithError("Exception: " . $e->getMessage());
}
?>
