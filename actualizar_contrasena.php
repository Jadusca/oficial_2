<?php
include('conexion.php');

if (isset($_POST['token']) && isset($_POST['nueva_contrasena'])) {
    $token = $conectar->real_escape_string($_POST['token']);
    $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

    // Asegurarte que el token sea válido y no expirado antes de actualizar
    $query = "SELECT * FROM super_administradores WHERE token='$token' AND token_expira > NOW()";
    $result = $conectar->query($query);

    if ($result->num_rows > 0) {
        $update = "UPDATE super_administradores
                   SET contrasena='$nueva_contrasena', token=NULL, token_expira=NULL
                   WHERE token='$token'";

        if ($conectar->query($update)) {
            echo "<script>alert('¡Tu contraseña ha sido cambiada con éxito!'); window.location.href='iniciosesionSuperAdmin.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar contraseña.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
        }
    } else {
        echo "<script>alert('El enlace ya expiró o es inválido.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
    }
}
?>
