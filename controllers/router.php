<?php
require_once 'Controller.php';
require_once 'ProveedorController.php';
require_once 'ProductController.php';
require_once 'PublicidadController.php';
require_once 'UserController.php';
require_once 'VentasController.php';
require_once 'CompraController.php';
require_once 'SendWhatsApp.php';
require_once 'SMTPemail.php';

if (isset($_REQUEST['op'])) {
    $action = $_REQUEST['op'];
    $publicidadC = new PublicidadController();
    $controller = new Controller();
    $productC = new ProductController();
    $userC = new UserController();
    $ventaC = new VentasController();
    $compraC = new ComprasController();
    $proveedorC = new ProveedorController();
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            handleGetRequest($action, $productC, $userC, $ventaC, $compraC, $publicidadC, $proveedorC, $controller);
            break;
        case 'POST':
            handlePostRequest($action, $productC, $userC, $ventaC, $compraC, $publicidadC, $proveedorC, $controller);
            break;
        default:
            handleInvalidMethod();
            break;
    }
} else {
    handleMissingParameter();
}

function handleGetRequest($action, $productController, $userController, $ventaController, $compraController, $publicidadController, $proveedorController, $controller)
{
    try {
        switch ($action) {
            case 'getProducts':
                $productController->getProducts();
                break;
            case 'getProductsShop':
                $productController->getProductsShop();
                break;
            case 'getPrecioShop':
                $productController->getPrecioShop();
                break;
            case 'getProductsAlert':
                $productController->getProductsAlert();
                break;
            case 'getProductsCliente':
                $ventaController->getProductsCliente();
                break;

            case 'getProductDetail':
                $productController->getProductDetail();
                break;

            case 'getColoresTalla':
                $productController->getColoresTalla();
                break;
            case 'getTallasColor':
                $productController->getTallasColor();
                break;

            case 'getImgProd':
                $productController->getImgProd();
                break;
            case 'getAllImgProd':
                $productController->getAllImgProd();
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
            case 'getSliders':
                $publicidadController->getSliders();
                break;
            case 'getAllSliders':
                $publicidadController->getAllSliders();
                break;
            case 'getAllProveedores':
                $proveedorController->getAllProveedores();
                break;
            case 'getProveedores':
                $proveedorController->getProveedores();
                break;
            case 'getAllVentas':
                $ventaController->getAllVentas();
                break;
            case 'getVentas':
                $ventaController->getVentas();
                break;
            case 'getDetalleVentas':
                $ventaController->getDetalleVentas();
                break;


            case 'getTallas':
                $controller->getTallas();
                break;
            case 'getColores':
                $controller->getColores();
                break;
            case 'getTipoPrenda':
                $controller->getTipoPrenda();
                break;
            case 'getGenero':
                $controller->getGenero();
                break;
            case 'getOcasion':
                $controller->getOcasion();
                break;
            case 'getCategorias':
                $controller->getCategorias();
                break;
            default:
                handleNotFound();
                break;
        }
    } catch (error) {
        handleNotFound();
    }
}

function handlePostRequest($action, $productController, $userController, $ventaController, $compraController, $publicidadController, $proveedorController, $controller)
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

        case 'updateUser':
            $userController->updateUsers();
            break;
        case 'deleteUser':
            $userController->deleteUsers();
            break;



        case 'insertSlider':
            $publicidadController->insertSliders();
            break;
        case 'updateSlider':
            $publicidadController->updateSliders();
            break;
        case 'deleteSlider':
            $publicidadController->deleteSliders();
            break;

        case 'insertProveedor':
            $proveedorController->insertProveedores();
            break;
        case 'updateProveedor':
            $proveedorController->updateProveedores();
            break;
        case 'deleteProveedor':
            $proveedorController->deleteProveedores();
            break;

        case 'insertProduct':
            $productController->insertProduct();
            break;
        case 'updateProduct':
            $productController->updateProduct();
            break;
        case 'deleteProduct':
            $productController->deleteProduct();
            break;



        case 'insertCompra':
            $compraController->insertCompras();
            break;
        case 'updateCompra':
            $publicidadController->updateSliders();
            break;
        case 'deleteCompra':
            $publicidadController->deleteSliders();
            break;


        case 'insertVentaClient':
            $ventaController->insertVentaClient();
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
