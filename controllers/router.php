<?php
require_once 'ProductController.php';
require_once 'PublicidadController.php';
require_once 'UserController.php';
require_once 'VentasController.php';
require_once 'SendWhatsApp.php';
require_once 'SMTPemail.php';

if (isset($_REQUEST['op'])) {
    $action = $_REQUEST['op'];
    $publicidadC = new PublicidadController();
    $productC = new ProductController();
    $userC = new UserController();
    $ventaC = new VentasController();
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            handleGetRequest($action, $productC, $userC, $ventaC, $publicidadC);
            break;
        case 'POST':
            handlePostRequest($action, $productC, $userC, $ventaC, $publicidadC);
            break;
        default:
            handleInvalidMethod();
            break;
    }
} else {
    handleMissingParameter();
}

function handleGetRequest($action, $productController, $userController, $ventaController, $publicidadController)
{
    try {
        switch ($action) {
            case 'getProducts':
                $productController->getProducts();
                break;
            case 'getProductsAlert':
                $productController->getProductsAlert();
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
            case 'getAllUsers':
                $userController->getAllUsers();
                break;

            case 'getEstadisticas':
                $ventaController->getEstadistica();
                break;

            case 'getAllSliders':
                $publicidadController->getAllSliders();
                break;
            case 'getAllSliders':
                $publicidadController->getAllSliders();
                break;
            case 'getAllSliders':
                $publicidadController->getAllSliders();
                break;
            default:
                handleNotFound();
                break;
        }
    } catch (error) {
        handleNotFound();
    }
}

function handlePostRequest($action, $productController, $userController, $ventaC, $publicidadController)
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
        case 'send_alerta_whatsapp':
            $data = json_decode(file_get_contents('php://input'), true);
            $sendWhatsApp = new SendWhatsApp();
            $sendWhatsApp->enviarMensajes($data['productos']);
            break;
        case 'send_email':
            $sendEmail = new SendEmail('ventas@asotaeco.com.ec', 'Ventas123@', 'ventas@asotaeco.com.ec');
            $sendEmail->enviarMensajes('paulluna99@gmail.com', 'Asunto', 'Cuerpo');
            break;

        case 'insertSlider':
            $publicidadController->insertSliders();
            break;
        case 'updateSlider':
            $publicidadController->updateSliders();
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
