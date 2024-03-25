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
    public function getVentas()
    {
        // Obtener datos desde el modelo
        $model = new VentaModel();
        $data = $model->getAllVentas();
        // Verificar si se encontraron datos
        if ($data === false || empty($data)) {
            // No se encontraron datos, devolver un código de estado 204 (Sin contenido)
            http_response_code(204);
        } else {
            // Devolver los datos como JSON
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
    public function getTallasProd()
    {
        $model = new VentaModel();
        $data = $model->getTallasProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getWishList()
    {
        $model = new VentaModel();
        $data = $model->getWishList();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }

    public function getImgProd()
    {
        $model = new VentaModel();
        $data = $model->getImgProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }

    public function getColoresTalla()
    {
        $model = new VentaModel();
        $data = $model->getColoresTalla();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }


    public function getSliders()
    {
        // Obtener datos desde el modelo
        $model = new VentaModel();
        $data = $model->getSliders();
        // Verificar si se encontraron datos
        if ($data === false || empty($data)) {
            // No se encontraron datos, devolver un código de estado 204 (Sin contenido)
            http_response_code(204);
        } else {
            // Devolver los datos como JSON
            echo json_encode($data);
        }
    }
}
