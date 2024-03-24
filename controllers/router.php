<?php
require_once 'ProductController.php';
require_once 'UserController.php';

if (isset($_REQUEST['op'])) {
    $action = $_REQUEST['op'];

    $productC = new ProductController();
    $userC = new UserController();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            handleGetRequest($action, $productC, $userC);
            break;
        case 'POST':
            handlePostRequest($action, $productC, $userC);
            break;
        default:
            handleInvalidMethod();
            break;
    }
} else {
    handleMissingParameter();
}

function handleGetRequest($action, $productController, $userController)
{
    try {
        switch ($action) {
            case 'getProducts':
                $productController->getProducts();
                break;
            case 'getSliders':
                $productController->getSliders();
                break;
            case 'getProductDetail':
                $productController->getProductDetail();
                break;
            case 'getTallasProd':
                $productController->getTallasProd();
                break;
            case 'getColoresTalla':
                $productController->getColoresTalla();
                break;
            case 'getImgProd':
                $productController->getImgProd();
                break;
            case 'getWishList':
                $productController->getWishList();
                break;
            case 'getUserData':
                $userController->getUserData();
                break;
            default:
                handleNotFound();
                break;
        }
    } catch (error) {
        handleNotFound();
    }
}

function handlePostRequest($action, $productController, $userController)
{
    // try {
    switch ($action) {
        case 'login':
            $email = $_POST["email"];
            $password = $_POST["pass"];
            $userController->login($email, $password);
            break;
        case 'registro':
            $email = $_POST["email"];
            $password = $_POST["pass"];
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $cedula = $_POST["cedula"];

            if (isset($_POST['rol_id'])) {
                $rol = $_POST['rol_id'];
            } else {
                $rol = 2; 
            }

            $userController->registrar($email, $password, $nombre, $direccion, $cedula, $rol);
            break;
        case 'createUser':
            $userController->createUser();
            break;
        case 'resetpassci':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $ci = $_POST["ci"];
                $userController->getClientByEmailAndCi($email, $ci);
            }
            break;
        case 'createProduct':
            $productController->createProduct();
            break;
        default:
            handleNotFound();
            break;
    }
    // } catch (error) {
    //     handleNotFound();
    // }
}

function handleInvalidMethod()
{
    http_response_code(405);
    echo json_encode(array("message" => "Método no permitido."));
}

function handleMissingParameter()
{
    http_response_code(400);
    echo json_encode(array("message" => "Parámetro 'op' faltante en la solicitud."));
}

function handleNotFound()
{
    http_response_code(404);
    echo json_encode(array("message" => "La acción solicitada no existe."));
}
