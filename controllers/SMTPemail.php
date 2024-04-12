<?php

require_once '../vendor/autoload.php';
require_once '../config/smtp.php';
require_once '../config/Conectar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SmtpModel extends Conectar
{


    public function enviarCorreo($email, $nombre, $asunto, $body)
    {
        try {
            // $mailer = new PHPMailer(true);
            // $mailer->isSMTP();
            // $mailer->Host = 'smtp.hostinger.com';
            // $mailer->SMTPAuth = true;
            // $mailer->Username = 'info@asotaeco.com';
            // $mailer->Password = 'Asotaeco1@';
            // $mailer->SMTPSecure = 'ssl';
            // $mailer->Port = 465;

            // $nombre = $_POST['nombre'];
            // $apellido = $_POST['apellido'];
            // $email = $_POST['email'];
            // $asunto = $_POST['asunto'];
            // $mensaje = $_POST['mensaje'];

            $nombre = "Alexander";
            $apellido = "Luna";
            $email = "paulluna99@gmail.com";
            $asunto = "asunto";
            $mensaje = "asdasdasdasdasd";
            // $foto = $_FILES['foto']; //array assoc - $foto['tmp_name']; $foto['size'] - $foto['name']
            $foto = "";
            if (empty(trim($nombre))) $nombre = 'anonimo';
            if (empty(trim($apellido))) $apellido = '';

            $body = <<<HTML
    <h1>Contacto desde la web</h1>
    <p>De: $nombre $apellido / $email</p>
    <h2>Mensaje</h2>
    $mensaje
HTML;

            $mailer = new PHPMailer(true);
            $mailer->setFrom($email, "$nombre $apellido");
            $mailer->addAddress('info@asotaeco.com', 'Sitio web');
            $mailer->Subject = "Mensaje web: $asunto";
            $mailer->msgHTML($body);
            $mailer->AltBody = strip_tags($body);
            $mailer->CharSet = 'UTF-8';

            if ($foto['size'] > 0) {
                $mailer->addAttachment($foto['tmp_name'], $foto['name']);
            }

            $rta =  $mailer->send();
            return $rta;
        } catch (Exception $e) {
            return false;
        }
    }
}
