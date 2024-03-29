<?php

require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmail
{
    private $smtpHost = 'smtp.hostinger.com';
    private $smtpPort = 465;
    private $smtpUsername;
    private $smtpPassword;
    private $senderEmail;

    public function __construct($smtpUsername, $smtpPassword, $senderEmail)
    {
        $this->smtpUsername = $smtpUsername;
        $this->smtpPassword = $smtpPassword;
        $this->senderEmail = $senderEmail;
    }

    public function enviarMensajes($destinatario, $asunto, $cuerpo)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->Port = $this->smtpPort;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpUsername;
            $mail->Password = $this->smtpPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            // Configuración del remitente y destinatario
            $mail->setFrom($this->senderEmail, 'Nombre del Remitente');
            $mail->addAddress($destinatario);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;

            // Enviar el correo
            $mail->send();
            http_response_code(201);
            echo json_encode('Correo enviado correctamente');
        } catch (Exception $e) {
            http_response_code(400);
            $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
            $errorResponse = [
                "http_code" => http_response_code(),
                "error" => $errorMsg
            ];
            $errorJson = json_encode($errorResponse);
            return $errorJson;
        }
    }
}
?>
