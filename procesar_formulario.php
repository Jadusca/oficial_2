<?php
include 'conexion.php';

// Recoger los datos del formulario
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$genero = $_POST["genero"];
$biblioteca = $_POST["biblioteca"];
$numero_celular = $_POST["numero_celular"];
$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

// Aquí va el SQL para insertar directo a la tabla administradores
$sql = "INSERT INTO administradores (nombre, apellido, email, fecha_nacimiento, genero, biblioteca, numero_celular, usuario, contrasena)
        VALUES ('$nombre', '$apellido', '$email', '$fecha_nacimiento', '$genero', '$biblioteca', '$numero_celular', '$usuario', '$contrasena')";

if ($conectar->query($sql) === TRUE) {
    echo '<script>
            alert("✅ Datos insertados correctamente");
            window.location.href="listaUsuariosSuperAdmin.php";
        </script>';
} else {
    echo "❌ Error al insertar datos: " . $conectar->error;
}

// Cerrar conexión
$conectar->close();
?>
