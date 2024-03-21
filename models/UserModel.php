<?php
require_once '../config/Conectar.php'; // Asegúrate de incluir la clase Conectar

class UserModel extends Conectar
{
    public function getAllUsers()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            // Obtener los resultados
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    public function getAllClients()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios WHERE rol_id=2";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            // Obtener los resultados
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    public function getClientById($clientId)
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios WHERE rol_id = 2 AND id = :id";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $clientId, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener el cliente
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            return $client;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
    public function getClientByEmail($clientEmail)
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios WHERE rol_id = 2 AND email = :email";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':email', $clientEmail, PDO::PARAM_STR);
            $stmt->execute();

            // Obtener el cliente
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            return $client;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
    public function getClientByEmailAndCi($clientEmail, $ci)
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios WHERE email = :email AND cedula = :ci";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':email', $clientEmail, PDO::PARAM_STR);
            $stmt->bindParam(':ci', $ci, PDO::PARAM_STR);
            $stmt->execute();

            // Obtener el cliente
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            return $client;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener los datos: " . $e->getMessage());
        }
    }

    public function encriptarPassword($password)
    {
        $options = [
            'cost' => 12,
        ];
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        return $hash;
    }
    public function resetpass_usuario($usu_id, $usu_pass)
    {
        try {
            $conectar = parent::conexion();
            $sql = "UPDATE usuarios
                    SET
                        pass = ?
                    WHERE
                        id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, encriptarPassword($usu_pass));
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            $resultado = $sql->fetchAll();
            return $resultado;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
    /*TODO: Funcion para login de acceso del usuario */
    public function actualizarPassword($usu_id, $usu_pass)
    {
        try {
            $conectar = parent::conexion();
            $sql = "UPDATE usuarios SET pass = ? WHERE id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
    public function login()
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            if (isset($_POST["enviar"])) {
                $correo = $_POST["email"];
                $pass = $_POST["pass"];
                if (empty($correo) and empty($pass)) {
                    /*TODO: En caso esten vacios correo y contraseña, devolver al index con mensaje = 2 */
                    header("Location:" . "index.php?m=2");
                    exit();
                } else {
                    $sql = "SELECT password FROM usuarios WHERE email=? and est=1";
                    $stmt = $conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->execute();
                    $resultado1 = $stmt->fetch();

                    if ($resultado1) {
                        $hashAlmacenado = $resultado1['pass'];

                        // Verifica la contraseña utilizando password_verify
                        if (password_verify($pass, $hashAlmacenado)) {
                            $sql = "SELECT * FROM usuarios WHERE email=? and est=1";
                            $stmt = $conectar->prepare($sql);
                            $stmt->bindValue(1, $correo);
                            $stmt->execute();
                            $resultado = $stmt->fetch();

                            if ($resultado) {
                                // Establece las variables de sesión
                                $_SESSION["usu_id"] = $resultado["usu_id"];
                                $_SESSION["usu_nom"] = $resultado["usu_nom"];
                                $_SESSION["usu_email"] = $resultado["usu_correo"];
                                $_SESSION["rol_id"] = $resultado["rol_id"];
                                // Redirige al usuario a la página de inicio
                                header("Location: " . "/views/home/");
                                exit();
                            }
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
}
