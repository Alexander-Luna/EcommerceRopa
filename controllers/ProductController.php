<?php
require_once '../models/ProductModel.php';

class ProductController
{
    public function getProducts()
    {
        // Obtener datos desde el modelo
        $model = new ProductModel();
        $data = $model->getAllProducts();
        // Verificar si se encontraron datos
        if ($data === false || empty($data)) {
            // No se encontraron datos, devolver un código de estado 204 (Sin contenido)
            http_response_code(204);
        } else {
            // Devolver los datos como JSON
            echo json_encode($data);
        }
    }

    public function getProductDetail()
    {
        $model = new ProductModel();
        $data = $model->getProductDetail();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getTallasProd()
    {
        $model = new ProductModel();
        $data = $model->getTallasProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getImgProd()
    {
        $model = new ProductModel();
        $data = $model->getImgProd();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    
    public function getColoresTalla()
    {
        $model = new ProductModel();
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
        $model = new ProductModel();
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
