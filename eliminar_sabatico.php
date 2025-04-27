<?php
require "conexion.php";

$id = intval($_GET['id']);
$conectar->query("DELETE FROM sabaticos WHERE id_sabaticos = $id");

header("Location: modulo_sabaticos.php");
