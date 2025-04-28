<?php
include('conexion.php');

if (isset($_GET['idUsuario'])) {
    $userId = $_GET['idUsuario'];

    // Realizar la eliminación del usuario
    $sql = "DELETE FROM administradores WHERE id_administrador = $userId";
    $result = $conectar->query($sql);

    if ($result) {
        // Mensaje de éxito en la eliminación
        echo "<script>
                alert('Usuario eliminado correctamente');
                window.location.href = 'listaUsuariosSuperAdmin.php';
              </script>";
    } else {
        // Mensaje de error
        echo "Error al eliminar el usuario: " . $conn->error;
    }
} else {
    // Manejar el caso en que no se proporcionó un ID de usuario
    echo "No se proporcionó un ID de usuario.";
}

$conn->close();
?>
