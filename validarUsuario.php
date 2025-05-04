<?php
// validar_usuario.php
include 'conexion.php';

$usuario    = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$stmt = $conectar->prepare("
    SELECT nombre, contrasena
    FROM administradores
    WHERE usuario = ?
");
$stmt->bind_param("s", $usuario);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila        = $resultado->fetch_assoc();
    $hashGuardado = $fila['contrasena'];

    if (password_verify($contrasena, $hashGuardado)) {
        session_start();
        session_regenerate_id(true);

        // Guardamos sólo el nombre de usuario en sesión
        $_SESSION['nombreUsuario'] = $fila['nombre'];

        header("Location: indexadmin.php");
        exit;
    }
}

// Si llegamos aquí, usuario o clave no coinciden
header("Location: iniciosesion.php?error=1");
exit;

$stmt->close();
$conectar->close();

?>
