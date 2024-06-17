<?php

$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Consulta para obtener el total de turnos
$totalTurnosQuery = "SELECT COUNT(*) AS total_turnos FROM tb_turno_atendido";
$totalTurnosResult = $conn->query($totalTurnosQuery);
$totalTurnos = $totalTurnosResult->fetch_assoc()['total_turnos'];

// Consulta para obtener las dependencias y contar los turnos por cada una
$dependenciaQuery = "
    SELECT id_consulta, COUNT(*) AS count 
    FROM tb_turno_atendido 
    GROUP BY id_consulta
";
$dependenciaResult = $conn->query($dependenciaQuery);

$dependencias = [];
while ($row = $dependenciaResult->fetch_assoc()) {
    $dependencias[$row['id_consulta']] = $row['count'];
}

// Si no hay registros en la tabla para alguna dependencia, agregarla con 0 turnos
$allDependencias = ['A', 'B', 'C', 'D'];
foreach ($allDependencias as $dependencia) {
    if (!isset($dependencias[$dependencia])) {
        $dependencias[$dependencia] = 0;
    }
}

// Encontrar el máximo y mínimo número de turnos
$maxTurnos = max($dependencias);
$minTurnos = min($dependencias);

// Filtrar dependencias según el máximo y mínimo número de turnos
$dependenciasMasSolicitadas = [];
$dependenciasMenosSolicitadas = [];

foreach ($dependencias as $dependencia => $count) {
    if ($count == $maxTurnos) {
        $dependenciasMasSolicitadas[] = $dependencia;
    } elseif ($count == $minTurnos) {
        $dependenciasMenosSolicitadas[] = $dependencia;
    }
}

$response = [
    'total_turnos' => $totalTurnos,
    'dependencias_mas_solicitadas' => $dependenciasMasSolicitadas,
    'dependencias_menos_solicitadas' => $dependenciasMenosSolicitadas
];

echo json_encode($response);

$conn->close();
?>
