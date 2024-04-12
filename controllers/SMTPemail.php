<?php

require_once '../vendor/autoload.php';
require_once '../config/smtp.php';
require_once '../config/Conectar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SmtpModel extends Conectar
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.hostinger.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'info@asotaeco.com';
        $this->mail->Password = 'Asotaeco1@';
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;
    }

    public function enviarCorreo($email, $nombre, $asunto, $body)
    {
        try {
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco');
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
?>
