<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Revisados</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
    <style>
        .tabs {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            cursor: pointer;
            margin-bottom: 1em;
        }

        .tab {
            padding: 20px 60px;
            border-radius: 15px;
            font-size: 20px;
            border: 3px #003568 solid;
            color: #003568;
            margin-right: 5px;
            font-weight: bold;
            transition: all 0.5s linear;
        }

        .tab:hover {
            border: 3px #003568 solid;
            background-color: #003568;
            color: white;
        }

        .tab.active {
            background: #003568;
            border: 3px #003568 solid;
            color: white;
            font-weight: bold;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        #filtroInput {
            margin-bottom: 10px;
            padding: 5px;
            width: 40%;
        }
    </style>
</head>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="modulo_revision_general.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Documentos Revisados</h2>
    </div>

    <div class="docs_aprobados">
        <div class="tabs">
            <div class="tab active" data-tab="lic">Licenciaturas</div>
            <div class="tab" data-tab="pos">Posgrados</div>
            <div class="tab" data-tab="sab">Sabáticos</div>
        </div>
        <input type="text" id="filtroInput" placeholder="Filtrar por título o autor">
    </div>

    <div id="lic" class="tab-content active"></div>
    <div id="pos" class="tab-content"></div>
    <div id="sab" class="tab-content"></div>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');
        let currentTab = 'lic';
        let currentPage = 1;

        function cargarContenido(tab, page = 1, filtro = '') {
            fetch(`cargar_${tab}.php?page=${page}&filtro=${encodeURIComponent(filtro)}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(tab).innerHTML = data;
                });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                contents.forEach(c => c.classList.remove('active'));
                const tabName = tab.getAttribute('data-tab');
                document.getElementById(tabName).classList.add('active');

                currentTab = tabName;
                currentPage = 1;
                cargarContenido(currentTab, currentPage, document.getElementById('filtroInput').value);
            });
        });

        document.getElementById('filtroInput').addEventListener('input', () => {
            currentPage = 1;
            cargarContenido(currentTab, currentPage, document.getElementById('filtroInput').value);
        });

        function cambiarPagina(nuevaPagina) {
            currentPage = nuevaPagina;
            cargarContenido(currentTab, currentPage, document.getElementById('filtroInput').value);
        }

        // Cargar inicial
        cargarContenido('lic', 1);
    </script>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="funciones.js"></script>

</body>

</html>