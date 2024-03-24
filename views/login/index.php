<?php
session_start(); // Iniciar la sesión si aún no está iniciada

if (!isset($_SESSION["user_session"]) || !isset($_SESSION['user_session']['user_id'])) {
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

                <form id="loginForm">
                    <div class="p-3">
                        <div class="col-10 text-center input-group mb-3 mt-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico">
                        </div>
                        <div class="col-10 text-center input-group mb-3">
                            <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <button class="btn btn-primary col-10 p-3 text-center align-content-center mb-3" type="button" onclick="submitForm()">Entrar</button>
                    <a href="../resetpass/">¿Olvidé mi contraseña?</a>
                </form>

                <div id="formFooter">
                    <p>¿Aun no tienes una cuenta?</p>
                    <a class="underlineHover" href="../register/">Regístrate</a>
                </div>

            </div>
        </div>
        <?php require_once "../html/MainJS.php"; ?>
        <script src="content.js"></script>
    </body>

    </html>
<?php
} else {
    if ($_SESSION['user_session']['rol_id'] == "1") {
        // Si el rol del usuario es administrador
        header("Location: ../admindashboard/");
    } else {
        header("Location: ../home/");
    }
    exit();
}
?>