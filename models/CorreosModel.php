<?php

require_once '../vendor/autoload.php';
require_once '../config/smtp.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CorreosModel
{
    private $mail;

    public function enviarCorreo()
    {
        try {
            $email =  $_POST['email'];;
            $nombre = $_POST['nombre'];
            $asunto = $_POST['asunto'];
            $body = $_POST['mensaje'];
            $foto = $_POST['foto'];
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'info@asotaeco.com';
            $this->mail->Password = 'Asotaeco1@'; // Agrega tu contraseña aquí
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco');
            $this->mail->addAddress($email, $nombre);
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            // Adjuntar la foto al correo electrónico
            if ($foto['size'] > 0) {
                $this->mail->addAttachment($foto['tmp_name'], $foto['name']);
            }

            $rta = $this->mail->send();
            return "El correo se ha enviado correctamente.";
        } catch (Exception $e) {
            var_dump($e);
            return "Ha ocurrido un error al enviar el correo: " . $e->getMessage();
        }
    }
}
