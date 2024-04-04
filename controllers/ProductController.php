<?php
require_once '../models/ProductModel.php';

class ProductController
{
    public function getProducts()
    {
        $model = new ProductModel();
        $data = $model->getAllProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getProductsAlert()
    {
        $model = new ProductModel();
        $data = $model->getAllProductsAlert();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
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
    public function getWishList()
    {
        $model = new ProductModel();
        $data = $model->getWishList();
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
}
