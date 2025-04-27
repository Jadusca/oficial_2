<?php
include 'conexion.php';

$id = intval($_GET['id']); // Sanear el ID recibido

$contraseniaA = isset($_POST["contraseniaA"]) ? $_POST["contraseniaA"] : '';
$contraseniaN = isset($_POST["contraseniaN"]) ? $_POST["contraseniaN"] : '';
$contraseniaNC = isset($_POST["contraseniaNC"]) ? $_POST["contraseniaNC"] : '';

// Validar que los campos no estén vacíos
if (empty($contraseniaA) || empty($contraseniaN) || empty($contraseniaNC)) {
    echo "<script>alert('Por favor llene todos los campos.');
    window.history.back();
    </script>";
    exit();
}

// Traer la contraseña cifrada de la base de datos
$sql = "SELECT contrasena FROM super_administradores WHERE id_super_administrador = ?";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $row = $resultado->fetch_assoc();
    $contraA_DB = $row['contrasena'];

    // Verificar que la contraseña actual ingresada coincida con la guardada (cifrada)
    if (password_verify($contraseniaA, $contraA_DB)) {

        // Verificar que nueva contraseña y su confirmación coincidan
        if ($contraseniaN === $contraseniaNC) {

            // Cifrar la nueva contraseña antes de guardar
            $nuevoHash = password_hash($contraseniaN, PASSWORD_DEFAULT);

            // Actualizar en la base de datos
            $sql_update = "UPDATE super_administradores SET contrasena = ? WHERE id_super_administrador = ?";
            $stmt_update = $conectar->prepare($sql_update);
            $stmt_update->bind_param("si", $nuevoHash, $id);

            if ($stmt_update->execute()) {
                echo "<script>alert('Contraseña actualizada correctamente.');
                window.location.href='detallesuperuserSuperAdmin.php?idUsuario=$id';
                </script>";
            } else {
                echo "<script>alert('Error al actualizar contraseña. Intente de nuevo.');
                window.history.back();
                </script>";
            }

        } else {
            echo "<script>alert('La nueva contraseña y su confirmación no coinciden.');
            window.history.back();
            </script>";
        }

    } else {
        echo "<script>alert('La contraseña actual es incorrecta.');
        window.history.back();
        </script>";
    }

} else {
    echo "<script>alert('Usuario no encontrado.');
    window.history.back();
    </script>";
}

$conectar->close();
?>
