<?php
include 'conexion.php';

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$fecha_nacimiento = $_POST["fecha"];
$genero = $_POST["genero"];
$biblioteca = $_POST["biblioteca"];
$numero_celular = $_POST["numero"];
$usuario = $_POST["usuario"];
$contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); // Siempre cifrar contraseña

$sql = "INSERT INTO super_administradores (nombre, apellido, email, fecha_nacimiento, genero, biblioteca, numero_celular, usuario, contrasena)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conectar->prepare($sql);

if ($stmt === false) {
    die("Error preparando la consulta: " . $conectar->error);
}

$stmt->bind_param("sssssssss", $nombre, $apellido, $email, $fecha_nacimiento, $genero, $biblioteca, $numero_celular, $usuario, $contrasena);

if ($stmt->execute()) {
    echo '<script>alert("Datos insertados correctamente"); window.location.href="listaSuperUsuariosSuperAdmin.php";</script>';
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

$conectar->close();
?>
