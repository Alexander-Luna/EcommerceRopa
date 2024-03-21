<?php
/* Llamamos al archivo de conexion.php */
require_once("../../config/Conectar.php");
if (!isset($_SESSION["usu_id"])) {
    if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
        require_once("../../models/UserModel.php");
        $usuario = new UserModel();
        $usuario->login();
       
        die();
    }
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <?php require_once "../html/MainHead.php"; ?>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>

        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Icon -->
                <div class="fadeIn first mt-4">
                    <img src="../../public/images/icons/logo.png" id="icon" alt="User Icon" />
                    <h1>Iniciar Sesión</h1>
                </div>

                <!-- Login Form -->
                <form action="" method="post">
                    <?php
                    if (isset($_GET["m"])) {
                        switch ($_GET["m"]) {
                            case "1";
                    ?>

                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong class="d-block d-sm-inline-block-force">Error!</strong> Datos Incorrectos
                                </div>
                            <?php
                                break;

                            case "2";
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong class="d-block d-sm-inline-block-force">Error!</strong> Campos vacíos
                                </div>
                    <?php
                                break;
                        }
                    }
                    ?>
                    <div class="p-3">
                        <div class="col-10 text-center input-group mb-3 mt-3">
                            <input type="email" id="email" class="form-control" name="email" placeholder="Correo electrónico">
                        </div>

                        <div class="col-10 text-center input-group mb-3">
                            <input type="password" id="pass" class="form-control" name="pass" placeholder="Contraseña">
                        </div>
                    </div>

                    <button class="btn btn-primary col-10 p-3 text-center align-content-center mb-3" type="submit">Entrar</button>
                    <a href="../resetpass/">¿Olvidé mi contraseña?</a>



                </form>

                <div id="formFooter">
                    <p>¿Aun no tienes una cuenta?</p>
                    <a class="underlineHover" href="../register/">Regístrate</a>
                </div>

            </div>
        </div>
        <?php require_once "../html/MainJS.php"; ?>
    </body>

    </html>
<?php
} else {
    header("Location:" .  "../home/");
}
?>