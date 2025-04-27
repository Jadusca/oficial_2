<?php
$nombreUsuario = file_exists('nombreUsuario.txt') ? file_get_contents('nombreUsuario.txt') : 'Invitado';

if (empty($nombreUsuario)) {
    header("Location: iniciosesion.php");
    exit();
}

include 'conexion.php';

$id = $_GET['id'];

// Captura de los datos del formulario
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
$apellido = isset($_POST["apellidos"]) ? $_POST["apellidos"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : '';
$genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
$numero_celular = isset($_POST["numero_celular"]) ? $_POST["numero_celular"] : '';
$biblioteca = isset($_POST["biblioteca"]) ? $_POST["biblioteca"] : '';

// Construcción del SET dinámicamente
$setClause = '';
if (!empty($nombre)) $setClause .= "nombre = '$nombre', ";
if (!empty($apellido)) $setClause .= "apellido = '$apellido', ";
if (!empty($email)) $setClause .= "email = '$email', ";
if (!empty($fecha)) $setClause .= "fecha_nacimiento = '$fecha', ";
if (!empty($genero)) $setClause .= "genero = '$genero', ";
if (!empty($numero_celular)) $setClause .= "numero_celular = '$numero_celular', ";
if (!empty($biblioteca)) $setClause .= "biblioteca = '$biblioteca', ";

$setClause = rtrim($setClause, ', ');

// Asegurarnos que sí hay algo que actualizar
if (!empty($setClause)) {
    $sql = "UPDATE super_administradores SET $setClause WHERE id_super_administrador = $id";

    if ($conectar->query($sql) === TRUE) {
        echo "<script>
                alert('Datos actualizados correctamente');
                window.location.href='detallesuperuserSuperAdmin.php?idUsuario=$id';
              </script>";
    } else {
        echo "Error al actualizar datos: " . $conectar->error;
    }
} else {
    echo "<script>
            alert('No se recibió información para actualizar');
            window.location.href='detallesuperuserSuperAdmin.php?idUsuario=$id';
          </script>";
}

$conectar->close();
?>
