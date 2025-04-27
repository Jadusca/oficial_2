<?php
include('conexion.php');
include('correo_contra.php');

if (isset($_GET['token'])) {
    $token = $conectar->real_escape_string($_GET['token']);

    $query = "SELECT * FROM super_administradores WHERE token='$token'";
    $result = $conectar->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (strtotime($row['token_expira']) > time()) {
            // El token aún es válido, mostrar formulario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            background: linear-gradient(135deg, #2980b9, #6dd5fa);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.25);
            width: 300px;
            text-align: center;
        }
        .form-container h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }
        .form-container button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Restablecer Contraseña</h2>
    <form action="actualizar_contrasena.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
        <button type="submit">Cambiar Contraseña</button>
    </form>
</div>

</body>
</html>
<?php
        } else {
            // Token expirado: generar uno nuevo y mandar otro correo
            $nuevo_token = bin2hex(random_bytes(50));
            $nueva_expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $update = "UPDATE super_administradores SET token='$nuevo_token', token_expira='$nueva_expira' WHERE id_super_administrador={$row['id_super_administrador']}";
            if ($conectar->query($update)) {
                $nuevo_link = "http://localhost/oficial/resetear_contrasena.php?token=$nuevo_token";
                $mensaje = "<h1>Recupera tu contraseña</h1><p>Tu enlace anterior expiró. Usa este nuevo enlace:</p><a href='$nuevo_link'>$nuevo_link</a><p>Este enlace también expirará en 1 hora.</p>";

                enviarCorreo($row['email'], "Nuevo enlace para recuperar tu contraseña", $mensaje);

                echo "<script>alert('Tu enlace expiró. Te enviamos un nuevo enlace al correo.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
            } else {
                echo "<script>alert('Error al generar nuevo enlace.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Enlace inválido.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
    }
} else {
    echo "<script>alert('Token no encontrado.'); window.location.href='iniciosesionSuperAdmin.php';</script>";
}
?>
