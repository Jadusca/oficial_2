<?php
include('conexion.php');
include('correo_contra.php');

if (isset($_POST['email'])) {
    $email = $conectar->real_escape_string($_POST['email']);

    $query = "SELECT * FROM super_administradores WHERE email = '$email'";
    $result = $conectar->query($query);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $update = "UPDATE super_administradores SET token='$token', token_expira='$expira' WHERE email='$email'";
        $conectar->query($update);

        // $link = "https://itmrepositorio.com/recuperar/resetear_contrasena.php?token=$token";

        $link = "http://localhost/oficial/resetear_contrasena.php?token=$token";

        $mensaje = "<h1>Recupera tu contraseña</h1><p>Haz clic aquí para cambiarla:</p><a href='$link'>$link</a><p>Este enlace expira en 1 hora.</p>";

        if (enviarCorreo($email, "Recupera tu contraseña", $mensaje)) {
            echo "<script>
                    alert('Correo enviado. Revisa tu bandeja.');
                    window.location.href = 'iniciosesionSuperAdmin.php';
                </script>";
        } else {
            echo "<script>
                    alert('Error al enviar el correo.');
                    window.location.href = 'iniciosesionSuperAdmin.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Correo no encontrado.');
                window.location.href = 'iniciosesionSuperAdmin.php';
            </script>";
    }
}
?>
