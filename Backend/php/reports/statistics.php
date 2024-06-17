<?php
require_once('tcpdf/tcpdf.php');

$serverName = "localhost";
$userName = "root";
$password = "root";
$database = "shift_management_system";

$conn = mysqli_connect($serverName, $userName, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Consulta para obtener los usuarios
$usuariosQuery = "SELECT * FROM tb_usuario";
$resultUsuarios = mysqli_query($conn, $usuariosQuery);

// Consulta para obtener los funcionarios
$funcionariosQuery = "SELECT * FROM tb_funcionario";
$resultFuncionarios = mysqli_query($conn, $funcionariosQuery);

// Consulta para obtener los turnos
$turnosQuery = "SELECT * FROM tb_turno";
$resultTurnos = mysqli_query($conn, $turnosQuery);

// Consulta para obtener los logs de login
$logsQuery = "SELECT * FROM login_logs";
$resultLogs = mysqli_query($conn, $logsQuery);

// Consulta para obtener los turnos atendidos
$turnosAtendidosQuery = "SELECT * FROM tb_turno_atendido";
$resultTurnosAtendidos = mysqli_query($conn, $turnosAtendidosQuery);

// Consultas para obtener datos de las tablas
$usuarioQuery = "SELECT COUNT(*) AS total_usuarios FROM tb_usuario";
$resultUsuario = mysqli_query($conn, $usuarioQuery);
$rowUsuario = mysqli_fetch_assoc($resultUsuario);
$totalUsuarios = $rowUsuario['total_usuarios'];

// Ejemplo para tb_tipo_consulta
$tipoConsultaQuery = "SELECT * FROM tb_tipo_consulta";
$resultTipoConsulta = mysqli_query($conn, $tipoConsultaQuery);

// Ejemplo para tb_funcionario
$funcionarioQuery = "SELECT COUNT(*) AS total_funcionarios FROM tb_funcionario";
$resultFuncionario = mysqli_query($conn, $funcionarioQuery);
$rowFuncionario = mysqli_fetch_assoc($resultFuncionario);
$totalFuncionarios = $rowFuncionario['total_funcionarios'];

// Ejemplo para tb_turno
$turnoQuery = "SELECT COUNT(*) AS total_turnos FROM tb_turno";
$resultTurno = mysqli_query($conn, $turnoQuery);
$rowTurno = mysqli_fetch_assoc($resultTurno);
$totalTurnos = $rowTurno['total_turnos'];

// Ejemplo para login_logs
$loginLogsQuery = "SELECT COUNT(*) AS total_logs FROM login_logs";
$resultLoginLogs = mysqli_query($conn, $loginLogsQuery);
$rowLoginLogs = mysqli_fetch_assoc($resultLoginLogs);
$totalLogs = $rowLoginLogs['total_logs'];

// Ejemplo para tb_turno_atendido
$turnoAtendidoQuery = "SELECT COUNT(*) AS total_turnos_atendidos FROM tb_turno_atendido";
$resultTurnoAtendido = mysqli_query($conn, $turnoAtendidoQuery);
$rowTurnoAtendido = mysqli_fetch_assoc($resultTurnoAtendido);
$totalTurnosAtendidos = $rowTurnoAtendido['total_turnos_atendidos'];

// Creación del documento PDF con TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Reporte de Estadísticas');
$pdf->SetMargins(15, 15, 15);

$pdf->AddPage();

// Agregar título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Estadísticas', 0, 1, 'C');

// Tabla de Usuarios
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Usuarios', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th  style="text-align: center;"><b>Cédula</b></th>
                    <th  style="text-align: center;"><b>Nombre</b></th>
                    <th  style="text-align: center;"><b>Apellido</b></th>
                    <th  style="text-align: center;"><b>Teléfono</b></th>
                    <th  style="text-align: center;"><b>Email</b></th>
                </tr>
            </thead>
            <tbody>';

// Mostrar los datos de los usuarios
while ($row = mysqli_fetch_assoc($resultUsuarios)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['cedula'] . '</td>
                <td style="text-align: center;">' . $row['nombre'] . '</td>
                <td style="text-align: center;">' . $row['apellido'] . '</td>
                <td style="text-align: center;">' . $row['telefono'] . '</td>
                <td style="text-align: center;">' . $row['email'] . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Mostrar el total de usuarios
$html .= '<p>Total de Usuarios: ' . $totalUsuarios . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// Tabla de Tipos de Consulta
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Tipos de Consulta', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>Código</b></th>
                    <th style="text-align: center;"><b>Descripción</b></th>
                </tr>
            </thead>
            <tbody>';
while ($row = mysqli_fetch_assoc($resultTipoConsulta)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['codigo'] . '</td>
                <td style="text-align: center;">' . $row['descripcion'] . '</td>
             </tr>';
}
$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Tabla de Funcionarios
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Funcionarios', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>Cédula</b></th>
                    <th style="text-align: center;"><b>Nombre</b></th>
                    <th style="text-align: center;"><b>Apellido</b></th>
                    <th style="text-align: center;"><b>Email</b></th>
                </tr>
            </thead>
            <tbody>';

// Mostrar los datos de los funcionarios
while ($row = mysqli_fetch_assoc($resultFuncionarios)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['cedula'] . '</td>
                <td style="text-align: center;">' . $row['nombre'] . '</td>
                <td style="text-align: center;">' . $row['apellido'] . '</td>
                <td style="text-align: center;">' . $row['email'] . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Mostrar el total de funcionarios
$html .= '<p>Total de Funcionarios: ' . $totalFuncionarios . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// Tabla de Turnos
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Turnos', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>ID Turno</b></th>
                    <th style="text-align: center;"><b>ID Usuario</b></th>
                    <th style="text-align: center;"><b>ID Consulta</b></th>
                    <th style="text-align: center;"><b>ID Funcionario</b></th>
                    <th style="text-align: center;"><b>Descripción</b></th>
                    <th style="text-align: center;"><b>Fecha</b></th>
                    <th style="text-align: center;"><b>Hora</b></th>
                </tr>
            </thead>
            <tbody>';

// Mostrar los datos de los turnos
while ($row = mysqli_fetch_assoc($resultTurnos)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['id_turno'] . '</td>
                <td style="text-align: center;">' . $row['id_usuario'] . '</td>
                <td style="text-align: center;">' . $row['id_consulta'] . '</td>
                <td style="text-align: center;">' . $row['id_funcionario'] . '</td>
                <td style="text-align: center;">' . $row['desc_turno'] . '</td>
                <td style="text-align: center;">' . $row['fecha'] . '</td>
                <td style="text-align: center;">' . $row['hora'] . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Mostrar el total de turnos
$html .= '<p>Total de Turnos: ' . $totalTurnos . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// Tabla de Logs de Login
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Logs de Login', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>ID</b></th>
                    <th style="text-align: center;"><b>ID Usuario</b></th>
                    <th style="text-align: center;"><b>ID Dependencia</b></th>
                    <th style="text-align: center;"><b>Fecha de Login</b></th>
                </tr>
            </thead>
            <tbody>';

// Mostrar los datos de los logs de login
while ($row = mysqli_fetch_assoc($resultLogs)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['id'] . '</td>
                <td style="text-align: center;">' . $row['user_id'] . '</td>
                <td style="text-align: center;">' . $row['id_dependencia'] . '</td>
                <td style="text-align: center;">' . $row['login_time'] . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Mostrar el total de logs de login
$html .= '<p>Total de Logs: ' . $totalLogs . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// Tabla de Turnos Atendidos
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Tabla de Turnos Atendidos', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

$html = '<table border="1">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>ID Turno Atendido</b></th>
                    <th style="text-align: center;"><b>ID Turno</b></th>
                    <th style="text-align: center;"><b>ID Usuario</b></th>
                    <th style="text-align: center;"><b>ID Consulta</b></th>
                    <th style="text-align: center;"><b>ID Funcionario</b></th>
                    <th style="text-align: center;"><b>Descripción</b></th>
                    <th style="text-align: center;"><b>Fecha</b></th>
                    <th style="text-align: center;"><b>Hora</b></th>
                    <th style="text-align: center;"><b>Fecha Atendido</b></th>
                    <th style="text-align: center;"><b>Hora Atendido</b></th>
                </tr>
            </thead>
            <tbody>';

// Mostrar los datos de los turnos atendidos
while ($row = mysqli_fetch_assoc($resultTurnosAtendidos)) {
    $html .= '<tr>
                <td style="text-align: center;">' . $row['id_turno_atendido'] . '</td>
                <td style="text-align: center;">' . $row['id_turno'] . '</td>
                <td style="text-align: center;">' . $row['id_usuario'] . '</td>
                <td style="text-align: center;">' . $row['id_consulta'] . '</td>
                <td style="text-align: center;">' . $row['id_funcionario'] . '</td>
                <td style="text-align: center;">' . $row['desc_turno'] . '</td>
                <td style="text-align: center;">' . $row['fecha'] . '</td>
                <td style="text-align: center;">' . $row['hora'] . '</td>
                <td style="text-align: center;">' . $row['fecha_atendido'] . '</td>
                <td style="text-align: center;">' . $row['hora_atendido'] . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Mostrar el total de turnos atendidos
$html .= '<p>Total de Turnos Atendidos: ' . $totalTurnosAtendidos . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// Finalizar y generar el PDF
$pdf->Output('reporte.pdf', 'I');

$conn->close();
?>
