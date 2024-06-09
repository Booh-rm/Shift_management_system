<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $serverName = "localhost";
    $userName = "root";
    $passwordDB = "";
    $database = "shift_management_system";

    $conn = mysqli_connect($serverName, $userName, $passwordDB, $database);

    if ($conn) {
        $stmt = $conn->prepare("DELETE FROM login_logs WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            $stmt->close();
            // Cerrar la sesión del usuario
            session_unset();
            session_destroy();
            echo json_encode(array('type' => 1, 'message' => 'Logout successful'));
        } else {
            echo json_encode(array('type' => 0, 'message' => 'Failed to delete log: ' . $stmt->error));
        }

        $conn->close();
    } else {
        echo json_encode(array('type' => 0, 'message' => 'Connection failed: ' . mysqli_connect_error()));
    }
} else {
    echo json_encode(array('type' => 0, 'message' => 'No user logged in'));
}
?>
