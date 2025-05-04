<?php
session_start();
include 'conexion.php';

$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

// Usar consulta preparada para mayor seguridad
$stmt = $conectar->prepare("SELECT * FROM administradores WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();

    if (password_verify($contrasena, $fila['contrasena'])) {
        $_SESSION['admin_id'] = $fila['id_administrador'];
        $_SESSION['admin_usuario'] = $fila['nombre'];
        $_SESSION['admin_genero'] = $fila['genero'];

        // Determinar mensaje de bienvenida
        $mensajeBienvenida = ($fila['genero'] === 'Femenino') ? '¡Bienvenida, ' : '¡Bienvenido, ';
        $nombreUsuario = $fila['nombre'];

        echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-image: url(Imagenes/Inicio_Sesion/tec.jpeg); background-size: cover; background-position: center; color: white; font-size: 3em; display: flex; justify-content: center; align-items: center; text-align: center; z-index: 999;'>";
        echo "<div style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4);'></div>";
        echo "<div style='position: relative; z-index: 1000;'>$mensajeBienvenida $nombreUsuario!</div>";
        echo "</div>";

        echo "<script>setTimeout(function() { window.location = 'indexadmin.php'; }, 2000);</script>";
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
