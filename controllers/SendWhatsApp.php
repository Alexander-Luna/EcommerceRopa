<?php
require_once '../public/vendor/autoload.php';

use Twilio\Rest\Client;

class SendWhatsApp
{
    public function enviarMensajes($productos)
    {
        $sid    = "ACe9ed0ae8ab647406fac5b502cc9b4cf7";
        $token  = "433edcd045c5526b52f0087b453040d5";

        try {
            $twilio = new Client($sid, $token);

            foreach ($productos as $producto) {
                $imagen = "http://192.168.1.13/tesis/clienteecommerce" . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
                // echo $imagen;
                // die();
                $messageBody = "Nombre del Producto: " . $producto['nombre'] . "\n";
                $messageBody .= "Cantidad Predeterminada: " . $producto['cant_pred'] . "\n";
                $messageBody .= "Proveedor: " . $producto['nombre_proveedor'] . "\n";
                $messageBody .= "Estado: " . ($producto['stock'] > 0 ? "Disponible" : "Agotado") . "\n";
                $phoneNumber = $producto['telefono'];

                if (!filter_var($imagen, FILTER_VALIDATE_URL)) {
                    throw new Exception("La URL de la imagen no es válida: $imagen");
                }

                // Crear el mensaje con la imagen
                $message = $twilio->messages->create(
                    "whatsapp:" . $phoneNumber,
                    [
                        "from" => "whatsapp:+14155238886",
                        "body" => $messageBody,
                        "mediaUrl" => [$imagen]
                    ]
                );

                // Verificar si el mensaje se envió correctamente
                if ($message->errorCode) {
                    http_response_code(500); // Error interno del servidor
                    throw new Exception("Error al enviar mensaje a $phoneNumber: " . $message->errorCode);
                }

                print("Mensaje SID para $phoneNumber: " . $message->sid . PHP_EOL);
            }

            // Envío exitoso, responder con código HTTP 200 (OK)
            http_response_code(200);
            echo "Mensajes enviados correctamente";
        } catch (Exception $e) {
            // Manejar errores
            http_response_code(500); // Error interno del servidor
            echo "Error al enviar mensajes: " . $e->getMessage();
        }
    }
}
