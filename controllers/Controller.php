<?php
require_once '../models/InventarioModel.php';

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
}
