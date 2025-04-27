<?php

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($destinatario, $asunto, $mensajeHTML) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Cambiar
        $mail->SMTPAuth   = true;
        $mail->Username = 'residenciajl1@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'ohdnysmnxbeecwur'; // Contraseña de aplicació
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('residenciajl1@gmail.com', 'Sistema de recuperacion contrasena');
        $mail->addAddress($destinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensajeHTML;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>