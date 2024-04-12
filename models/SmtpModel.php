<?php

require_once '../vendor/autoload.php';
require_once '../config/smtp.php';
require_once '../config/Conectar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SmtpModel
{

    public function enviarCorreo()
    {
        try {

            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $asunto = $_POST['asunto'];
            $body = $_POST['mensaje'];


            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'info@asotaeco.com';
            $this->mail->Password = 'Asotaeco1@';
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            $this->mail->setFrom('paulluna99@gmail.com', 'Asotaeco');
            $this->mail->addAddress($email, $nombre);
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            $rta = $this->mail->send();
            return $rta;
        } catch (Exception $e) {
            return false;
        }
    }
}
