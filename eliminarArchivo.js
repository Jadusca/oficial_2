document.getElementById('opcerrar').addEventListener('click', function(e) {
    e.preventDefault(); // Evita que el enlace siga el href

    // Realiza una solicitud al servidor para borrar el archivo
    fetch('eliminar_archivo.php')
        .then(response => response.text())
            window.location.href = 'iniciosesion.php';
});
document.getElementById('opcerrar2').addEventListener('click', function(e) {
    e.preventDefault(); // Evita que el enlace siga el href

    // Realiza una solicitud al servidor para borrar el archivo
    fetch('eliminar_archivo.php')
        .then(response => response.text())
            window.location.href = 'iniciosesion.php';
});