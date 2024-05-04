<?php
require_once '../models/SendWhatsAppModel.php';

class NotificationsController
{


    public function enviarProveedores($telefono)
    {
        try {
            $model = new SendWhatsAppModel();
            $data = $model->enviarMensajesProveedor($telefono);
            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al realizar la transacción'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    
}
