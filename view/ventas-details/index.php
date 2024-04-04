<?php
session_start();
// if (!isset($_SESSION["user_session"]) && $_SESSION['user_session']['rol_id'] === 1) {
if (isset($_SESSION['user_session'])) {
    $userData = $_SESSION['user_session'];
    // echo $userData['user'];
    // die();
    $modulo = $_REQUEST['modulo'] ?? '';
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asotaeco | Dashboard</title>
        <?php require_once('../html/header.php'); ?>
    </head>

    <body class="layout-fixed">
        <div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ventas: Ropa que debes conocer </h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row row-12">
                                <table id="miTabla" class="table table-bordered col-12" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre Producto</th>
                                            <th>Imagen</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Total Producto</th>
                                            <th>Color</th>
                                            <th>Talla</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se llenarán los datos dinámicamente -->
                                    </tbody>
                                </table>
                                <div class="col-2">
                                    <div class="card-body flex">
                                        <span>Sub Total: </span><span id="subTotal">$5000</span>
                                        <br>
                                        <span>Envio: </span><span id="envio">$5000</span>
                                        <br>
                                        <span>Total: </span><span id="total">$5000</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <script src="../ventas-details/content.js"></script>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once('../html/MainJS.php') ?>

    </body>

    </html>
<?php
} else {
    header("Location: ../../index.php");
    exit();
}
?>