<?php
require __DIR__ . '../twilio-php/src/Twilio/autoload.php';

use Twilio\Rest\Client;

function sendSMS($toPhone, $descTurno) {
    $sid    = "AC5442c195851da4ea4bf7416397313b45";
    $token  = "f37d3270a53a73218432a67e43eb3be9";
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
