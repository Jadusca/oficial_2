<?php
include 'conexion.php';

$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

$sql = "SELECT * FROM super_administradores WHERE usuario = '$usuario'";
$resultado = $conectar->query($sql);

if($resultado->num_rows > 0){
    $fila = $resultado->fetch_assoc();

    // Aquí verificamos la contraseña hasheada
    if(password_verify($contrasena, $fila['contrasena'])){

        $nombreUsuario = $fila['nombre'];
        $id = $fila['id_super_administrador'];

        // Almacena el nombre de usuario y id en caché
        file_put_contents('nombreUsuario.txt', $nombreUsuario);
        if($id === '1'){
            file_put_contents('idUsuario.txt', $id);
        }

        // Determinar el mensaje de bienvenida según el género del nombre de usuario
        $mensajeBienvenida = ($fila['genero'] === 'Femenino') ? '¡Bienvenida, ' : '¡Bienvenido, ';

        // Mensaje de bienvenida
        echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-image: url(Imagenes/Inicio_Sesion/tec.jpeg); background-size: cover; background-position: center; color: white; font-size: 3em; display: flex; justify-content: center; align-items: center; text-align: center; z-index: 999;'>";
        echo "<div style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4);'></div>";
        echo "<div style='position: relative; z-index: 1000;'>$mensajeBienvenida $nombreUsuario!</div>";
        echo "</div>";

        // Redirecciona a indexSuperadmin.php después de 2 segundos
        echo "<script>setTimeout(function() { window.location = 'indexSuperAdmin.php'; }, 2000);</script>";

    } else {
        // Contraseña incorrecta
        header("Location:iniciosesionSuperAdmin.php?error=1");
    }

} else {
    // Usuario no encontrado
    header("Location:iniciosesionSuperAdmin.php?error=1");
}

$conectar->close();
?>
