<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentos Revisados</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .tabs {
            display: flex;
            cursor: pointer;
            margin-bottom: 1em;
        }
        .tab {
            padding: 10px 20px;
            background: #eee;
            border: 1px solid #ccc;
            margin-right: 5px;
        }
        .tab.active {
            background: #ddd;
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

<h2>Documentos Revisados</h2>

<input type="text" id="filtroInput" placeholder="Filtrar por título o autor">

<div class="tabs">
    <div class="tab active" data-tab="lic">Licenciaturas</div>
    <div class="tab" data-tab="pos">Posgrados</div>
    <div class="tab" data-tab="sab">Sabáticos</div>
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

</body>
</html>
