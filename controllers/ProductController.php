<?php
require_once '../models/ProductModel.php';

class ProductController
{

    public function insertProduct()
    {
        $model = new ProductModel();
        $data = $model->insertProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function updateProduct()
    {
        $model = new ProductModel();
        $data = $model->updateProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function deleteProduct()
    {
        $model = new ProductModel();
        $data = $model->deleteProduct();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getAllProducts()
    {
        $model = new ProductModel();
        $data = $model->getAllProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getProducts()
    {
        $model = new ProductModel();
        $data = $model->getProducts();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getProductsShop()
    {
        $model = new ProductModel();
        $data = $model->getProductsShop();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
    public function getPrecioShop()
    {
        $model = new ProductModel();
        $data = $model->getPrecioShop();
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
    public function getAllImgProd()
    {
        $model = new ProductModel();
        $data = $model->getAllImgProd();
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
    public function getTallasColor()
    {
        $model = new ProductModel();
        $data = $model->getTallasColor();
        if ($data === false || empty($data)) {
            http_response_code(204);
        } else {
            echo json_encode($data);
        }
    }
}
