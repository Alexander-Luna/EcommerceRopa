<?php
require_once '../config/Conectar.php';

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

    public function getUserData()
    {
        try {
            session_start();
            $userData = $_SESSION['user_session'];
            $id_user =  $userData['user_id'];
            $conexion = parent::Conexion();

            $sql = "SELECT * FROM usuarios WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id_user);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Cambio realizado aquí, usando fetch() en lugar de fetchAll()
            return $user;
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function resetPassClient()
    {
        try {
            $conexion = parent::Conexion();
            $email = $_POST["email"];

            $ci = $_POST["ci"];
            // // Crear una instancia del modelo SmtpModel
            // $smtpModel = new SmtpModel();

            // // Llamar al método enviarCorreo
            // $resultadoEnvio = $smtpModel->enviarCorreo(
            //     'paulluna99@gmail.com',
            //     'Nombre Destinatario',
            //     'Asunto del Correo',
            //     'Cuerpo del Correo'
            // );
        } catch (Exception $e) {
            // Manejo de errores
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    public function getAllEmpresa()
    {
        try {
            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos

            $sql = "SELECT * FROM usuarios WHERE rol_id=1";

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
            $sql->bindValue(1,  $this->encriptarPassword($usu_pass));
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            $resultado = $sql->fetchAll();
            return $resultado;
        } catch (PDOException $e) {
            die("Error al obtener cliente: " . $e->getMessage());
        }
    }
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
        $email = $_POST["email"];
        $password = $_POST["pass"];
        $conexion = parent::Conexion();
        $sql = "SELECT u.* FROM usuarios u 
        WHERE u.email = ? AND u.est = 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        try {
            if (password_verify($password, $data['pass'])) {
                $sql1 = "SELECT u.rol_id,u.id as user_id,u.email,u.nombre ,u.direccion ,u.cedula,u.est
                , r.nombre AS rol_nombre FROM usuarios u JOIN roles r ON u.rol_id = r.id 
        WHERE u.email = ? AND u.est = 1";
                $stmt1 = $conexion->prepare($sql1);
                $stmt1->bindValue(1, $email);
                $stmt1->execute();
                $user = $stmt1->fetch(PDO::FETCH_ASSOC);
                return $user;
            }
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al iniciar sesión: " . $e->getMessage());
        }
    }


    public function registrarUsuario()
    {
        try {
            $email = $_POST["email"];
            $password = $_POST["pass"];
            $nombre = $_POST["nombre"];
            $provincias = $_POST["provincias"];
            $direccion = $_POST["direccion"];
            $cedula = $_POST["cedula"];

            if (isset($_POST['rol_id'])) {
                $rol = $_POST['rol_id'];
            } else {
                $rol = 2;
            }

            $conexion = parent::Conexion();
            $hashedPassword =  $this->encriptarPassword($password);
            $sql = "INSERT INTO usuarios (email, pass, nombre, direccion, cedula, rol_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->bindValue(2, $hashedPassword);
            $stmt->bindValue(3, $nombre);
            $stmt->bindValue(4, $provincias . " - " . $direccion);
            $stmt->bindValue(5, $cedula);
            $stmt->bindValue(6, $rol);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return $stmt;
            }
        } catch (PDOException $e) {
            die("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function updateUsers()
    {
        try {
            $id = $_POST["id"];
            $email = $_POST["email"];
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $cedula = $_POST["cedula"];
            $rol_id = $_POST["rol_id"];
            $telefono = $_POST["telefono"];
            if ($rol_id == "" || is_null($rol_id)) {
                $rol_id = 2;
            }

            $conexion = parent::Conexion(); // Obtener la conexión a la base de datos
            $sql = "UPDATE usuarios SET email=?, nombre=?, direccion=?, cedula=?, telefono=?, rol_id=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->bindValue(2, $nombre);
            $stmt->bindValue(3, $direccion);
            $stmt->bindValue(4, $cedula);
            $stmt->bindValue(5, $telefono);
            $stmt->bindValue(6, $rol_id);
            $stmt->bindValue(7, $id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se ha actualizado el registro correctamente
            if ($stmt->rowCount() > 0) {
                return true; // Se ha actualizado correctamente
            } else {
                throw new Exception("No se ha podido actualizar el registro");
            }
        } catch (PDOException $e) {
            die("Error al actualizar los datos: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function deleteUsers()
    {
        try {
            $id = $_POST["id"];
            $conexion = parent::Conexion();

            // Obtener el valor actual del campo 'est' para el usuario
            $stmt = $conexion->prepare("SELECT est FROM usuarios WHERE id=?");
            $stmt->execute([$id]);
            $currentStatus = $stmt->fetchColumn();

            // Invertir el valor del campo 'est'
            $newStatus = ($currentStatus == 1) ? 0 : 1;

            // Actualizar el campo 'est' con el nuevo valor
            $sql = "UPDATE usuarios SET est = ? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $newStatus);
            $stmt->bindValue(2, $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true; // El estado del usuario se ha cambiado correctamente
            } else {
                throw new Exception("No se ha podido cambiar el estado del usuario");
            }
        } catch (PDOException $e) {
            die("Error al cambiar el estado del usuario: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
