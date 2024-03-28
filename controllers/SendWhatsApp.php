<?php

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;

class SendWhatsApp
{
    public function enviarMensajes($productos)
    {
        $token = "GA240327220917";

        try {
            $client = new Client(['verify' => false]);

            $payload = [
                "op" => "registermessage",
                "token_qr" => $token,
                "mensajes" => [],
            ];
           
            foreach ($productos as $producto) {
                $imagen = "	http://192.168.1.62/tesis/clienteecommerce" . str_replace("//", "/", str_replace("..", "", $producto['imagen']));

                $mensaje = [
                    "numero" => $producto['telefono'],
                    "mensaje" => "Nombre del Producto: " . $producto['nombre'] . "\n" .
                        "Cantidad Predeterminada: " . $producto['cant_pred'] . "\n" .
                        "Proveedor: " . $producto['nombre_proveedor'] . "\n" .
                        "Estado: " . ($producto['stock'] > 0 ? "Disponible" : "Agotado") . "\n",
                ];

                // if (!empty($imagen)) {
                //     if (!filter_var($imagen, FILTER_VALIDATE_URL)) {
                //         throw new Exception("La URL de la imagen no es válida: $imagen");
                //     }
                //     $imageContent = file_get_contents($imagen);
                //     $imageBase64 = base64_encode($imageContent);
                //     $mensaje["url"] = $imageBase64;
                // }

                $payload["mensajes"][] = $mensaje;
            }


            $response = $client->post('https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);
            $httpCode = $response->getStatusCode();
            $body = $response->getBody();
            $jsonResponse = [
                "http_code" => $httpCode,
                "body" => $body,
                "payload" => $payload
            ];
            $jsonString = json_encode($jsonResponse);
            http_response_code(200);
            return $jsonString;
        } catch (Exception $e) {
            http_response_code(400);
            $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
            $errorResponse = [
                "http_code" => http_response_code(),
                "error" => $errorMsg
            ];
            $errorJson = json_encode($errorResponse);
            return $errorJson;
        }
    }
}

// Ejemplo de uso
$productos = [
    [
        "id_producto" => 32,
        "id_talla" => 1,
        "id_color" => 1,
        "id_proveedor" => 1,
        "stock" => 50,
        "stock_alert" => 5,
        "cant_pred" => 0,
        "costo" => "50.50",
        "precio_venta" => "80.50",
        "id" => 32,
        "nombre" => "Camisa",
        "precio" => "10.00",
        "existencia" => 23,
        "descripcion" => "Niños (2 años)",
        "activo" => 1,
        "id_categoria" => 1,
        "tipo" => "Camisa",
        "color" => "Rojo",
        "genero" => "Hombre",
        "talla" => "2T",
        "imagen" => "..\/..\/public\/images\/products\/product-01.jpg",
        "telefono" => "51986321853"
    ]
];
