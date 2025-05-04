<?php
include 'conexion.php';

$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];


$stmt = $conectar->prepare("SELECT * FROM administradores WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();

// Obtener el resultado
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $hashGuardado = $fila['contrasena'];


    if (password_verify($contrasena, $hashGuardado)) {
        session_start();
        $_SESSION['nombreUsuario'] = $fila['nombre'];
        $_SESSION['privilegios'] = $fila['privilegiosSu'] ?? '0'; // Si no existe, pone '0'

        header("Location: indexadmin.php");
        exit;
    } else {

        header("Location: iniciosesion.php?error=1");
        exit;
    }
} else {

    header("Location: iniciosesion.php?error=1");
    exit;
}

$stmt->close();
$conectar->close();
?>
