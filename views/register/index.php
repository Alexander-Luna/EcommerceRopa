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

            <form id="registroForm">
                <div class="p-3">
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombres y apellidos">
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Correo electrónico">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="provincias" name="provincias" required>
                            <option value="">Seleccione una provincia...</option>
                            <option value="Azuay">Azuay</option>
                            <option value="Bolívar">Bolívar</option>
                            <option value="Cañar">Cañar</option>
                            <option value="Carchi">Carchi</option>
                            <option value="Chimborazo">Chimborazo</option>
                            <option value="Cotopaxi">Cotopaxi</option>
                            <option value="El Oro">El Oro</option>
                            <option value="Esmeraldas">Esmeraldas</option>
                            <option value="Galápagos">Galápagos</option>
                            <option value="Guayas">Guayas</option>
                            <option value="Imbabura">Imbabura</option>
                            <option value="Loja">Loja</option>
                            <option value="Los Ríos">Los Ríos</option>
                            <option value="Manabí">Manabí</option>
                            <option value="Morona Santiago">Morona Santiago</option>
                            <option value="Napo">Napo</option>
                            <option value="Orellana">Orellana</option>
                            <option value="Pastaza">Pastaza</option>
                            <option value="Pichincha">Pichincha</option>
                            <option value="Santa Elena">Santa Elena</option>
                            <option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
                            <option value="Sucumbíos">Sucumbíos</option>
                            <option value="Tungurahua">Tungurahua</option>
                            <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                        </select>
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="text" id="direccion" class="form-control" name="direccion" placeholder="Dirección">
                    </div>
                    <div class="col-10 text-center input-group mb-3 mt-3">
                        <input type="number" id="cedula" class="form-control" name="cedula" pattern="[0-9]*" placeholder="Cédula">
                    </div>
                    <div class="col-10 text-center input-group mb-3">
                        <input type="password" id="pass" class="form-control" name="pass" placeholder="Contraseña">
                    </div>
                    <div class="col-10 text-center input-group mb-3">
                        <input type="password" id="confpass" class="form-control" name="confpass" placeholder="Repita su contraseña">
                    </div>
                </div>

                <button class="btn btn-primary col-10 p-3 text-center align-content-center mb-3" type="button" onclick="submitForm()">Registrar</button>
                <a href="../resetpass/">¿Olvidé mi contraseña?</a>


            </form>

            <div id="formFooter">
                <p>¿Ya tienes una cuenta?</p>
                <a class="underlineHover" href="../login/">Iniciar sesión</a>
            </div>

        </div>
    </div>
    <?php require_once "../html/MainJS.php"; ?>
    <script src="content.js"></script>
</body>

</html>