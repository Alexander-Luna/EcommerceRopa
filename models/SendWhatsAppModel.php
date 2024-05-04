<?php

require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/PDFModel.php';
require_once '../models/CorreosModel.php';

use GuzzleHttp\Client;

class SendWhatsAppModel
{
    private  $token = "GA240503202714";
    public function enviarMensajesProveedor($telefono)
    {
        $client = new Client(['verify' => false]);
        $respuestas = array();
        $messageBody = "Espero que este mensaje lo/a encuentre bien. Le saluda de parte de *ASOTAECO*. Me complace informarle que se ha enviado un correo electrónico a la dirección proporcionada con los detalles necesarios para solicitar un nuevo pedido de productos.
        Dentro del correo electrónico, encontrará toda la información relevante, incluyendo los productos requeridos, cantidades, especificaciones y cualquier otra instrucción importante para completar el pedido de manera satisfactoria.
        Por favor, revise su bandeja de entrada (y también la carpeta de spam o correo no deseado, si es necesario) para encontrar el correo electrónico enviado desde nuestra parte. Si tiene alguna pregunta o necesita asistencia adicional, no dude en ponerse en contacto con nosotros.
        Agradecemos mucho su atención y cooperación en este proceso. Esperamos continuar nuestra sólida asociación comercial y estamos ansiosos por recibir su respuesta.
        Gracias y saludos cordiales.";
        $telefono = substr($telefono, -9);
        $payload = array(
            "op" => "registermessage",
            "token_qr" => $this->token,
            "mensajes" => array(
                array("numero" => "593" . $telefono, "mensaje" => $messageBody)
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

            $respuesta = array(
                'codigo' => $response->getStatusCode(),
                'mensaje' => $response->getBody()->getContents()
            );
            $respuestas[] = $respuesta;
        } catch (Exception $e) {
            $respuesta = array(
                'codigo' => 500, // Indica un error interno del servidor
                'mensaje' => "Error al enviar mensajes: " . $e->getMessage()
            );
            $respuestas[] = $respuesta;
        }

        return $respuestas;
    }
    public function enviarMensajes($productos)
    {



        try {

            $client = new Client(['verify' => false]);

            foreach ($productos as $producto) {
                $telefono = $producto['telefono'];
                $url =  Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
                $imageData = file_get_contents($url);
                $base64Image = base64_encode($imageData);

                $payload = array(
                    "op" => "registermessage",
                    "token_qr" => $this->token,
                    "mensajes" => array(
                        array(
                            "numero" => $telefono, "mensaje" => "Hola,👋 *",
                        ),
                        array("numero" => $telefono, "imagenbase64" => $base64Image)
                    )
                );
                $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ], 'json' =>  $payload
                ]);
                $response = [
                    "http_code" => $res->getStatusCode(),
                    "sms" => $res->getBody()
                ];
                echo $response;
            }
            return $res->getBody();
        } catch (Exception $e) {
            http_response_code(400);
            $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
        }
    }
}



// class SendWhatsApp
// {
//     public function getToken()
//     {
//         return "PA240410210517";
//     }

//     public function enviarMensajes($productos)
// {
//     try {
//         $client = new Client(['verify' => false]);
//         $responses = [];

//         foreach ($productos as $producto) {
//             // Asegurarse de que los datos del producto sean correctos
//             var_dump($producto);

//             $telefono = $producto['telefono'];
//             $url =  Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
//             $imageData = file_get_contents($url);
//             $base64Image = base64_encode($imageData);

//             $payload = array(
//                 "op" => "registermessage",
//                 "token_qr" => $this->getToken(),
//                 "mensajes" => array(
//                     array(
//                         "numero" => $telefono,
//                         "mensaje" => "Hola,👋 *" . $producto['nombre_proveedor'] . "*\n" .
//                             " este es el sistema de alertas automaticas de *ASOTAECO* para hacer un pedido de: \n" .
//                             "*Producto:* " . $producto['nombre_producto'] . "\n" .
//                             "*Descripción:* " . $producto['descripcion_producto'] . "\n" .
//                             "*Tipo:* " . $producto['tipo'] . "\n" .
//                             "*Color:* " . $producto['color'] . "\n" .
//                             "*Talla:* " . $producto['talla'] . "\n" .
//                             "*Cantidad que se desea adquirir:* " . $producto['cant_pred'] . " Unidades\n" .
//                             "Para solicitar este producto, por favor comuníquese a este número lo mas pronto posible.\nAdjunto imagen de la prenda requerida👇"
//                     ),
//                     array("numero" => $telefono, "imagenbase64" => $base64Image)
//                 )
//             );

//             // Imprime el payload para verificar que sea correcto
//             var_dump($payload);

//             $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
//                 'headers' => [
//                     'Content-Type' => 'application/json',
//                     'Accept' => 'application/json'
//                 ],
//                 'json' =>  $payload
//             ]);

//             $response = [
//                 "http_code" => $res->getStatusCode(),
//                 "sms" => $res->getBody()
//             ];

//             // Añade la respuesta a un array para un manejo posterior
//             $responses[] = $response;
//         }
//         // Devuelve todas las respuestas como JSON
//         return json_encode($responses);
//     } catch (Exception $e) {
//         // Captura y maneja cualquier error que pueda ocurrir
//         http_response_code(400);
//         $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
//         $errorResponse = [
//             "http_code" => http_response_code(),
//             "error" => $errorMsg
//         ];
//         $errorJson = json_encode($errorResponse);
//         return $errorJson;
//     }
// }

//     public function enviarMensaje()
//     {
//         try {

//             $client = new Client(['verify' => false]);

//             $telefono = "593985726434";
//             $payload = array(
//                 "op" => "registermessage",
//                 "token_qr" => $this->getToken(),
//                 "mensajes" => array(
//                     array(
//                         "numero" => $telefono, "mensaje" => "Hola,👋 Adjunto imagen de la prenda requerida👇"
//                     )
//                     //array("numero" => $telefono, "imagenbase64" => $base64Image)
//                 )
//             );
//             $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
//                 'headers' => [
//                     'Content-Type' => 'application/json',
//                     'Accept' => 'application/json'
//                 ], 'json' =>  $payload
//             ]);
            
//             return json_encode($res);
//         } catch (Exception $e) {
//             http_response_code(400);
//             $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
//             $errorResponse = [
//                 "http_code" => http_response_code(),
//                 "error" => $errorMsg
//             ];
//             $errorJson = json_encode($errorResponse);
//             return $errorJson;
//         }
//     }
// }
