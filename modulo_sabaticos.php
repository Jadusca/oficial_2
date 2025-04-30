<head>
    <meta charset="UTF-8">
    <title>Gestión de Posgrados</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<?php
include "headerSuperadmin.php";
?>

<div class="edit_car">
    <div class="menu1_1">
        <a class="arrow" href="herramientas.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <h2 class="tit_mod_car">Agregar nuevo sabático</h2>
</div>

<?php
require "conexion.php";

// Obtener sabáticos existentes
$result = $conectar->query("SELECT * FROM sabaticos");
?>

<form class="nuevas_carreras" action="guardar_sabatico.php" method="POST">
    <section>
        <label>Nombre del sabático:</label><br>
        <input type="text" name="nombre_sabatico" required>
    </section><br><br>

    <section>
        <label>Año del sabático (opcional):</label><br>
        <input type="number" name="anio_sabatico">
    </section><br><br>

    <input class="mod_car" type="submit" value="Guardar">
</form>

<h2 class="tit_mod_car">Lista de sabáticos</h2>
<table class="tab_mod">
    <tr>
        <th>Nombre</th>
        <th>Año</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nombre_sabatico']) ?></td>
            <td><?= htmlspecialchars($row['anio_sabatico']) ?></td>
            <td>
                <div class="actions">
                    <div class="pdf_busqueda">
                        <a href="editar_sabatico.php?id=<?= $row['id_sabaticos'] ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                    <div class="pdf_busqueda">
                        <a href="eliminar_sabatico.php?id=<?= $row['id_sabaticos'] ?>"
                            onclick="return confirm('¿Estás seguro de eliminar este sabático?')"><i
                                class="fa-solid fa-trash-can"></i></a>
                    </div>
                </div>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<br><br>

<?php
include "footer.php";
?>