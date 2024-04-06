<?php
require_once '../models/UserModel.php';

class UserController
{
    public function getUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        echo json_encode($users);
    }
    public function getAllUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        echo json_encode($users);
    }
    public function updateUsers()
    {
        try {
            $model = new UserModel();
            $data = $model->updateUsers();
            if ($data) {
                http_response_code(200);
                echo json_encode($data);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al actualizar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
 
    public function deleteUsers()
    {
        try {
            $model = new UserModel();
            $data = $model->deleteUsers();

            if ($data) {
                http_response_code(200);
                echo json_encode($data);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Error al eliminar los datos'));
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }




    public function registrar($email, $password, $nombre, $direccion, $cedula, $rol)
    {
        $userModel = new UserModel();
        $users = $userModel->registrarUsuario($email, $password, $nombre, $direccion, $cedula, $rol);
        echo json_encode($users);
    }
    public function login($email, $password)
    {
        try {
            $userModel = new UserModel();
            $userData = $userModel->login($email, $password);

            if ($userData) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_session'] = $userData;
                http_response_code(200);
                echo json_encode($userData);
           } else {
                http_response_code(204);
                echo json_encode(array('error' => 'Inicio de sesión fallido'));
            }
        } catch (Exception $e) {
            // Enviar una respuesta de error en caso de excepción con código HTTP 400
            http_response_code(400);
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}
