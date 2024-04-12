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
            $body1 = <<<HTML
          
            <html>
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>
                    </title>
                    <meta name="description" content="">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="">
                </head>
                <body>
                    <p>asdasdasdasdasdasd</p>

                    <script src="" async defer></script>
                </body>
            </html>
            HTML;
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco'); // Reemplaza con tu correo y nombre
            $this->mail->addAddress($email, $nombre); // Reemplaza con el correo y nombre del destinatario
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $body;
            //$url = Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
            //$this->mail->addAttachment($url, 'nombre_imagen.jpg'); // Reemplaza 'nombre_imagen.jpg' con el nombre que desees para la imagen adjunta
            $this->mail->msgHTML($body1);
            $this->mail->AltBody = strip_tags($body);
            $rta = $this->mail->send();
            var_dump($rta);
            die();
            return $rta;
        } catch (Exception $e) {
            return false;
        }
    }
}
