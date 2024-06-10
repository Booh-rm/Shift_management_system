<?php
require_once 'sendgrid-php/sendgrid-php.php';
use SendGrid\Mail\Mail;

function sendEmail($emailUsuario, $nombreUsuario, $descTurno) {
    error_log("Enviando correo electrónico a: $emailUsuario, Nombre: $nombreUsuario, Descripción: $descTurno");

    $email = new Mail();
    $email->setFrom("appturnify@gmail.com", "Administración Turnify");
    $email->addTo($emailUsuario, $nombreUsuario);
    $email->setSubject("Detalles de su turno");
    $email->addContent("text/plain", $descTurno);

    $sendgrid = new \SendGrid('');
    
    try {
        $response = $sendgrid->send($email);
        error_log("Correo enviado, status code: " . $response->statusCode());
    } catch (Exception $e) {
        error_log('Error al enviar el correo: ' . $e->getMessage());
        // Re-lanzar la excepción para que sea manejada por el script principal
        throw $e;
    }
}
?>
