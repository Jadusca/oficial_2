<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="desktop.css" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="estilosmovil.css">
  <link rel="stylesheet" href="movil.css" />
  <script src="https://kit.fontawesome.com/600b045a2f.js" crossorigin="anonymous"></script>
  <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
  <title>Repositorio del Instituto Tecnologico de Merida</title>
  <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
</head>

<body>
  <?php
  include "headerSuperadmin.php";
  include "conexion.php";
  ?>

  <div class="menu1">
    <a class="arrow" href="listaSuperUsuariosSuperAdmin.php"><i class="fa-solid fa-arrow-left"></i></a>
  </div>
  <br>



  <?php
  if (isset($_GET['idUsuario'])) {
    $idDelUsuario = $_GET['idUsuario'];
  } else {
    header('Location: listaUsuarios.php');
    exit();
  }

  $sql = "SELECT * FROM super_administradores WHERE id_super_administrador = $idDelUsuario";
  $result = $conectar->query($sql);
  ?>
  <div id="subir" class="flecha">
    <i class="fa-solid fa-angle-up"></i>
  </div>
  <section class="ancho">
    <h1 class="tituloEU">Editar Usuario</h1>
    <div class="advertenciaEU">
      <p>ATENCIÓN. Usted está apunto de modificar los datos de este usuario por lo que se hace responsable de los
        cambios realizados, si no está seguro NO realice ningún cambio.</p>
    </div>

    <div class="detallesUsuario">
      <p>Detalles del Usuario</p>
      <div class="divDU">

        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<table class="tablaDU">
                <tr>
                    <th class="thDU">Número de Usuario</th>
                    <td class="tdDU">' . $row["id_super_administrador"] . '</td>
                </tr>
                <tr>
                    <th class="thDU">Usuario</th>
                    <td class="tdDU">' . $row["usuario"] . '</td>
                </tr>
                <tr>
                    <th class="thDU">Email</th>
                    <td class="tdDU">' . $row["email"] . '</td>
                </tr>
                <tr>
                    <th class="thDU">Biblioteca</th>
                    <td class="tdDU">' . $row["biblioteca"] . '</td>
                </tr>
            </table>';
          }
        }
        ?>

      </div>
    </div>

    <div class="formModificarDatos">
      <?php
      echo "<form method='post' class='formNuevoUsuario' action='actualizarDatosUsuario.php?id=$idDelUsuario'>";
      ?>

      <div class="lineaForm">
        <div>
          <p>Escriba su Nombre(s)</p>
          <label for="" class="tituloapartadoUs">Nombre(s):</label><br /><br />
          <input name="nombre" class="inputAU" type="text" />
        </div>
        <div>
          <p>Escriba su Apellido, Primero el paterno y luego el materno</p>
          <label for="" class="tituloapartadoUs">Apellidos:</label><br /><br />
          <input name="apellidos" class="inputAU" type="text" />
        </div>
      </div>
      <div class="lineaForm">
      <div>
            <p>Introduzca su número de celular</p>
            <label for="" class="tituloapartadoUs">Número de Celular:</label><br /><br />
            <input name="numero_celular" class="inputAU" type="text" maxlength="15" />
        </div>
      </div>

      <p class="tituloapartadoUs_p">Introduzca su correo</p>
      <label for="" class="tituloapartadoUs tituloapartadoUs_email">Email:</label><br /><br />
      <input name="email" class="email" type="text" /><br />

      <div class="seccionesdescribir">
        <p class="apartadodescribir">Introduzca su fecha de nacimiento</p>
        <div class="juntosdescribir juntosdescribir1">
          <h3 class="tituloapartado">Fecha de Nacimiento</h3>
          <div class="selecdescribir selecdescribir1">
          <input type="date" name="fecha">
        </div>
      </div>

      <div class="lineaForm">
        <div class="genero">
          <p>Seleccione su genero</p>
          <label class="tituloapartadoUs">Género</label><br /><br />
          <select class="selectAU" name="genero" id="">
            <option value="0"></option>
            <option value="Maculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
          </select>
        </div>


      </div>
      <p class="tit_biblioteca">Selecciona la biblioteca</p>
      <label for="" class="tituloapartadoUs tituloapartadoUs_biblioteca">Biblioteca</label><br /><br />
      <select class="selectAU selectAU_biblio" name="biblioteca" id="">
        <option value="0"></option>
        <option value="Antonio Mediz Bolio">Antonio Mediz Bolio</option>
      </select><br /><br />
      <div class="botonesfinalescompleto botonesfinalescompleto1">
        <input class="btnCancelarAdmin" type="button" value="Cancelar" onclick="cancelarEdicionUsuario()">
        <input class="btnSiguienteAdmin" type="submit" value="Guardar">
      </div>
      </form>
    </div>
  </section>

  <?php
  include "footer.php"
    ?>
  <script src="./funciones.js"></script>
  <script>
    // Función para redirigir a la página del documento
    function cancelarEdicionUsuario() {
      // Obtén el ID del documento desde la URL
      var idUsuario = <?php echo $idDelUsuario; ?>;

      // Redirige a la página del documento correspondiente
      window.location = 'detallesuperuserSuperAdmin.php?idUsuario=' + idUsuario;
    }
  </script>
</body>

</html>