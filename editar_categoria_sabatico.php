<?php
require "conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido.");
}

// Obtener datos de la categoría a editar
$stmt = $conectar->prepare("SELECT * FROM categoria_sabatico WHERE id_categoria_sab = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die("Categoría no encontrada.");
}

// Obtener lista de sabáticos para el select
$sabaticos = $conectar->query("SELECT * FROM sabaticos");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría de Sabático</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="modulo_categoria_sabatico.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar Categoría de Sabático</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_categoria_sabatico.php" method="POST">
        <input type="hidden" name="id_categoria_sab" value="<?= $categoria['id_categoria_sab'] ?>">

        <section>
            <label>Nombre de la categoría:</label><br>
            <input type="text" name="nombre_categoria" value="<?= htmlspecialchars($categoria['nombre_categoria']) ?>"
                required>
        </section><br><br>

        <section>
            <label>Sabático:</label><br>
            <select name="sabaticos" required>
                <option value="">Selecciona un sabático</option>
                <?php while ($sab = $sabaticos->fetch_assoc()): ?>
                    <option value="<?= $sab['id_sabaticos'] ?>" <?= ($sab['id_sabaticos'] == $categoria['sabaticos']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sab['nombre_sabatico']) ?> (<?= htmlspecialchars($sab['anio_sabatico']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="./funciones.js"></script>

</body>

</html>