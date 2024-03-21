<?php
require_once '../models/UserModel.php';

class UserController
{
    public function getUsers()
    {
        // Obtener usuarios desde el modelo
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();

        // Devolver los usuarios como JSON
        echo json_encode($users);
    }
    public function getClientByEmailAndCi($email, $ci)
    {
        $userModel = new UserModel();
        $users = $userModel->getClientByEmailAndCi($email, $ci);
        die(json_encode($users));
        echo json_encode($users);
    }
}
