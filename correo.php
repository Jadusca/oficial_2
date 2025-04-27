<?php
// Cargar PHPMailer manualmente
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($destinatarios, $asunto, $mensaje, $esIndividual = false) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'residenciajl1@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'ohdnysmnxbeecwur'; // Contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('residenciajl1@gmail.com', 'Sistema de Documentos');

        foreach ($destinatarios as $email) {
            if ($esIndividual) {
                $mail->addBCC($email);
            } else {
                $mail->addAddress($email);
            }
        }

        $mail->Subject = $asunto;
        $mail->Body = $mensaje;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
