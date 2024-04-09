<?php
require_once '../models/InventarioModel.php';
require_once '../models/DownloadPDF.php';
require_once '../models/ProductModel.php';

class Controller
{

    public function getTallas()
    {
        $model = new InventarioModel();
        $data = $model->getTallas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllTallas()
    {
        $model = new InventarioModel();
        $data = $model->getAllTallas();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getColores()
    {
        $model = new InventarioModel();
        $data = $model->getColores();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllColores()
    {
        $model = new InventarioModel();
        $data = $model->getAllColores();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getOcasion()
    {
        $model = new InventarioModel();
        $data = $model->getOcasion();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getTipoPrenda()
    {
        $model = new InventarioModel();
        $data = $model->getTipoPrenda();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getGenero()
    {
        $model = new InventarioModel();
        $data = $model->getGenero();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getCategorias()
    {
        $model = new InventarioModel();
        $data = $model->getCategorias();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function insertWishClient()
    {
        try {
            $model = new ProductModel();
            $data = $model->insertWishClient();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    public function getWishClient()
    {
        try {
            $model = new ProductModel();
            $data = $model->getWishClient();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    public function deleteWishClient()
    {
        try {
            $model = new ProductModel();
            $data = $model->deleteWishClient();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
    public function getVentaUser()
    {
        try {
            $model = new DownloadPDF();
            $data = $model->getVentaUser();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al insertar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
