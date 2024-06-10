<?php
require __DIR__ . '../twilio-php/src/Twilio/autoload.php';

use Twilio\Rest\Client;

function sendSMS($toPhone, $descTurno) {
    $sid    = "";
    $token  = "";
    $twilio = new Client($sid, $token);

    try {
        $message = $twilio->messages->create(
            $toPhone,
            [
                'from' => '+18777804236',
                'body' => $descTurno
            ]
        );
        return $message->sid;
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}
?>
