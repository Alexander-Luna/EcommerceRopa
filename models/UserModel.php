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
    public function login($email, $password)
    {
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


    public function registrarUsuario($email, $password, $nombre, $direccion, $cedula, $rol_id)
    {
        $conexion = parent::Conexion();
        $hashedPassword =  $this->encriptarPassword($password);
        $sql = "INSERT INTO usuarios (email, pass, nombre, direccion, cedula, rol_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, $hashedPassword);
        $stmt->bindValue(3, $nombre);
        $stmt->bindValue(4, $direccion);
        $stmt->bindValue(5, $cedula);
        $stmt->bindValue(6, $rol_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
