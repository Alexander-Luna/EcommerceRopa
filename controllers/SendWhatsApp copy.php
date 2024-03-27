<?php
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '../public/vendor/autoload.php'; // Ajusta la ruta según la ubicación de tu archivo router.php

use Twilio\Rest\Client;

$sid    = "ACe9ed0ae8ab647406fac5b502cc9b4cf7";
$token  = "433edcd045c5526b52f0087b453040d5";
$twilio = new Client($sid, $token);

$phoneNumbers = [
    "+593963616505",
    "+593981319473",
    "+593981413451",
];

$messageBody = "Mañana le agrego automático";

foreach ($phoneNumbers as $phoneNumber) {
    $message = $twilio->messages
        ->create(
            "whatsapp:" . $phoneNumber, // to
            [
                "from" => "whatsapp:+14155238886",
                "body" => $messageBody
            ]
        );
    print("Mensaje SID para $phoneNumber: " . $message->sid . PHP_EOL);
}
