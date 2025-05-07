<?php
$directorio = "Imagenes/Galería/";

for ($i = 1; $i <= 6; $i++) {
    if (!empty($_FILES["imagen$i"]["name"])) {
        $nombreTemporal = $_FILES["imagen$i"]["tmp_name"];
        $nombreDestino = $directorio . "gallery$i.jpg";
        move_uploaded_file($nombreTemporal, $nombreDestino);
    }
}

header("Location: modulo_galeria.php");
exit;
