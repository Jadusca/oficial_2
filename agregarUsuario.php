<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="desktop.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="movil.css"/>
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/600b045a2f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Repositorio del Instituto Tecnologico de Merida</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
  </head>

  <body>
    <?php
      include 'headerSuperadmin.php';
      include 'conexion.php';
    ?>

    <div id="subir" class="flecha">
      <i class="fa-solid fa-angle-up"></i>
    </div>

    <section class="seccionAgregarU ancho">
      <h1 class="blueh1">Agregar Nuevo Administrador</h1>

      <p>
        Por favor, rellene la información requerida para crear un nuevo
        usuario. Compruebe que la información sea escrita de manera correcta y
        sin ninguna falta de ortografía.
      </p>
      <br /><br />

      <form method="post" class="formNuevoUsuario" action="procesar_formulario.php" onsubmit="return validarFormulario();">
        <div class="lineaForm">
          <div>
            <p>Escriba su nombre completo</p>
            <label for="" class="tituloapartadoUs">Nombres:</label><br /><br />
            <input name="nombre" class="inputAU tituloapartadoUs" type="text" required />
          </div>
        </div>
        <div class="lineaForm">
        <div>
          <p>Escriba su(s) apellidos</p>
          <label for="" class="tituloapartadoUs">Apellidos:</label><br /><br />
          <input name="apellido" class="inputAU tituloapartadoUs" type="text" />
        </div>
        </div>

        <p class="tituloapartadoUs_email">Introduzca su correo</p>
        <label for="" class="tituloapartadoUs tituloapartadoUs_email">Email:</label><br /><br />
        <input name="email" class="email" type="email" required /><br />

        <div class="seccionesdescribir">
          <p class="apartadodescribir"></p>
          <br>
          <div class="juntosdescribir juntosdescribir2">
            <h3 class="tituloapartado">Fecha de Nacimiento</h3>
            <div class="selecdescribir selecdescribir2">
              <input type="date" name="fecha_nacimiento" required>
            </div>
          </div>
        </div>

        <div class="lineaForm">
          <div>
            <br><br>
            <label class="tituloapartadoUs">Género</label><br /><br />
            <select class="selectAU" name="genero" required>
              <option value="">Seleccione...</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
        </div>

        <p class="tit_biblioteca">Selecciona la biblioteca</p>
        <label for="" class="tituloapartadoUs tituloapartadoUs_biblioteca">Biblioteca</label><br /><br />
        <select class="selectAU selectAU_biblio" name="biblioteca" required>
          <option value="">Seleccione...</option>
          <option value="Antonio Mediz Bolio">Antonio Mediz Bolio</option>
        </select><br /><br />

        <p class="selectAU_biblio">Introduce el número de contacto</p>
        <label for="" class="selectAU_biblio">Número</label><br><br>
        <input name="numero_celular" class="inputAU inputAU_numero" type="text" required><br><br><br>

        <span class="blue name_usuario">Introduzca un nombre de usuario</span><br><br>
        <label class="usuario">Usuario</label><br /><br />
        <input name="usuario" class="inputUS" type="text" required />

        <div class="lineaForm">
          <div>
            <p>Contraseña mínima de 8 caracteres</p>
            <label for="password" class="tituloapartadoUs">Contraseña:</label><br /><br />
            <input class="inputPS" type="password" name="contrasena" id="passwordInput" required minlength="8" />
            <i class="fa-solid fa-eye-slash" onclick="togglePasswordVisibility()"></i>
          </div>
          <div>
            <p>Confirmar contraseña</p>
            <label for="" class="tituloapartadoUs">Confirmar Contraseña</label><br /><br />
            <input class="inputPS" type="password" id="passwordInputConfirmar" required minlength="8" />
            <i class="fa-solid fa-eye-slash" onclick="togglePasswordVisibilityConfirmar()"></i>
          </div>
        </div>

        <div class="botonesfinalescompleto botonesfinalescompleto1">
          <input class="btnCancelarAdmin" type="button" value="Cancelar" onclick="window.location='listaUsuarios.php';">
          <input class="btnSiguienteAdmin" type="submit" value="Guardar">
        </div>
      </form>
    </section>

    <?php include "footer.php" ?>

    <script src="codigo.js"></script>
    <script src="funciones.js"></script>

    <script>
      function togglePasswordVisibility() {
        const passwordInput = document.getElementById('passwordInput');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
      }

      function togglePasswordVisibilityConfirmar() {
        const passwordInputConfirmar = document.getElementById('passwordInputConfirmar');
        passwordInputConfirmar.type = passwordInputConfirmar.type === 'password' ? 'text' : 'password';
      }

      function validarFormulario() {
        const password = document.getElementById('passwordInput').value;
        const confirmar = document.getElementById('passwordInputConfirmar').value;

        if (password !== confirmar) {
          alert('⚠️ Las contraseñas no coinciden. Verifica por favor.');
          return false; // No envía el formulario
        }
        return true; // Envía el formulario si todo está correcto
      }
    </script>

  </body>
</html>
