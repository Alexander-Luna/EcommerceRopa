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
        $this->mail->Host = SMTP_HOST;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = SMTP_USERNAME;
        $this->mail->Password = SMTP_PASSWORD;
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;
    }

    public function enviarCorreo($email, $nombre, $asunto, $body)
    {
        try {
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco'); // Reemplaza con tu correo y nombre
            $this->mail->addAddress($email, $nombre); // Reemplaza con el correo y nombre del destinatario
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $body;
            //$url = Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
            //$this->mail->addAttachment($url, 'nombre_imagen.jpg'); // Reemplaza 'nombre_imagen.jpg' con el nombre que desees para la imagen adjunta
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
