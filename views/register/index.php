<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="styles.css">
    <?php require_once "../html/MainHead.php"; ?>
</head>

<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first mt-4">
                <img src="../../public/images/icons/logo.png" id="icon" alt="User Icon" />
                <h1>Regístrate</h1>
            </div>

            <!-- Login Form -->
            <form method="POST" action="submit">
                <div class="p-3">
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombres y apellidos">
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Correo electrónico">
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="text" id="direccion" class="form-control" name="direccion" placeholder="Dirección">
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="text" id="cedula" class="form-control" name="cedula" placeholder="Cédula">
                    </div>
                    <div class="col-10 text-center input-group mb-3">
                        <input type="password" id="pass" class="form-control" name="pass" placeholder="Contraseña">
                    </div>
                    <div class="col-10 text-center input-group mb-3">
                        <input type="password" id="confpass" class="form-control" name="confpass" placeholder="Repita su contraseña">
                    </div>
                </div>

                <button class="btn btn-primary col-10 p-3 text-center align-content-center mb-3" type="submit">Registrar</button>
                <a href="../resetpass/">¿Olvidé mi contraseña?</a>


            </form>

            <div id="formFooter">
                <p>¿Ya tienes una cuenta?</p>
                <a class="underlineHover" href="../login/">Iniciar sesión</a>
            </div>

        </div>
    </div>
    <?php require_once "../html/MainJS.php"; ?>
</body>

</html>