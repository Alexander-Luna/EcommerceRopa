<?php
require_once '../models/VentaModel.php';

class VentasController
{

    public function getEstadistica()
    {
        $model = new VentaModel();
        $data = $model->getEstadisticas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
 

    public function getVentaDetail()
    {
        $model = new VentaModel();
        $data = $model->getVentaDetail();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
  


    public function getVentas()
    {
        $ventaModel = new VentaModel();
        $ventas = $ventaModel->getAllVentas();
        echo json_encode($ventas);
    }

    public function getAllVentas()
    {
        $ventaModel = new VentaModel();
        $ventas = $ventaModel->getAllVentas();
        echo json_encode($ventas);
    }
    public function updateVentas()
    {
        try {
            $model = new VentaModel();
            $data = $model->updateVentas();
            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al actualizar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
 
    public function deleteVentas()
    {
        try {
            $model = new VentaModel();
            $data = $model->deleteVentas();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al eliminar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }

    public function insertVentas()
    {
        try {
            $model = new VentaModel();
            $data = $model->insertVentas();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
