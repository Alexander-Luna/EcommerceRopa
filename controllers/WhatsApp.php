<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

class SendWhatsApp
{
    public function enviarMensajes($productos)
    {
        $token = "PA240328204441";

        $client = new Client(['verify' => false]);

        foreach ($productos as $producto) {
            $messageBody = "Nombre del Producto: " . $producto['nombre'] . "\n";
            $messageBody .= "Cantidad Predeterminada: " . $producto['cant_pred'] . "\n";
            $messageBody .= "Proveedor: " . $producto['nombre_proveedor'] . "\n";
            $messageBody .= "Estado: " . ($producto['stock'] > 0 ? "Disponible" : "Agotado") . "\n";
            $phoneNumber = $producto['telefono'];

            $payload = array(
                "op" => "registermessage",
                "token_qr" => $token,
                "mensajes" => array(
                    array("numero" => $phoneNumber, "mensaje" => $messageBody)
                )
            );

            try {
                $response = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ],
                    'json' => $payload
                ]);

                echo $response->getStatusCode() . "<br>";
                echo $response->getBody() . "<br>";
            } catch (Exception $e) {
                // Handle errors
                echo "Error al enviar mensajes: " . $e->getMessage();
            }
        }
    }
}

// Uso de la clase SendWhatsApp
$sendWhatsApp = new SendWhatsApp();

// Suponiendo que $productos contiene los datos de los productosa
$productos = array(
    array(
        'nombre' => 'Producto 1',
        'cant_pred' => 5,
        'nombre_proveedor' => 'Proveedor 1',
        'stock' => 3,
        'telefono' => '593981319473' // Número de teléfono para enviar el mensaje
    ),
    array(
        'nombre' => 'Producto 2',
        'cant_pred' => 10,
        'nombre_proveedor' => 'Proveedor 2',
        'stock' => 0,
        'telefono' => '593981319474' // Otro número de teléfono para enviar el mensaje
    )
);

$sendWhatsApp->enviarMensajes($productos);
?>
