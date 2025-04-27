<?php

$host = "localhost";
$user = "root";
$contrasena = "";
$bd = "repositorio";

$conectar = mysqli_connect($host, $user, $contrasena, $bd);

if (!$conectar) {
  echo "no jalo :(";
}