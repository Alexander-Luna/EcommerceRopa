<?php

require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';

use GuzzleHttp\Client;

class SendWhatsApp
{
    public function enviarMensajes($productos)
    {
        $token = "PA240408215111";

        try {

            $client = new Client(['verify' => false]);

            foreach ($productos as $producto) {
                $telefono = $producto['telefono'];
                $url =  Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
                $imageData = file_get_contents($url);
                $base64Image = base64_encode($imageData);

                $payload = array(
                    "op" => "registermessage",
                    "token_qr" => $token,
                    "mensajes" => array(
                        array(
                            "numero" => $telefono, "mensaje" => "Hola,👋 *" . $producto['nombre_proveedor'] . "*\n" .
                                " este es el sistema de alertas automaticas de *ASOTAECO* para hacer un pedido de: \n" .
                                "*Producto:* " . $producto['nombre'] . "\n" .
                                "*Descripción:* " . $producto['descripcion'] . "\n" .
                                "*Tipo:* " . $producto['tipo'] . "\n" .
                                "*Color:* " . $producto['color'] . "\n" .
                                "*Talla:* " . $producto['talla'] . "\n" .
                                "*Cantidad que se desea adquirir:* " . $producto['cant_pred'] . " Unidades\n" .
                                "Para solicitar este producto, por favor comuníquese a este número lo mas pronto posible.\nAdjunto imagen de la prenda requerida👇"
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
            return json_encode($response);
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

// CAMPOS QUE SE PUEDEN USAR
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
