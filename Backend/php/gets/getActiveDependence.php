<?php

include('../config/config_mysqli.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    die(json_encode(array('type' => 0, 'message' => 'User not logged in')));
}

$user_dependencia = $_SESSION['id_dependencia'];

if (!$conn) {
    die(json_encode(array('type' => 0, 'message' => 'Connection failed: ' . mysqli_connect_error())));
}

// Consulta SQL para obtener el código y la descripción de las dependencias
$sql = "SELECT ll.id_dependencia, tc.descripcion 
        FROM login_logs ll
        INNER JOIN tb_tipo_consulta tc ON ll.id_dependencia = tc.codigo
        WHERE ll.id_dependencia != '0';";

// Ejecutar la consulta y verificar si se ha ejecutado correctamente
$result = mysqli_query($conn, $sql);
if (!$result) {
    die(json_encode(array('type' => 0, 'message' => 'Query failed: ' . mysqli_error($conn))));
}

// Array para almacenar las descripciones de las dependencias
$descriptionDp = array();

// Recorre los resultados de la consulta y añade las descripciones al array
while ($row = $result->fetch_assoc()) {
    $descriptionDp[] = [
        'id_dependencia' => $row['id_dependencia'],
        'descripcion' => $row['descripcion']
    ];
}

$conn->close();

echo json_encode($descriptionDp);
?>