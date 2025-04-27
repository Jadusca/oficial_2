// Cargar los periodos desde localStorage al cargar la página
window.onload = function () {
    for (let i = 1; i <= 4; i++) {
        const periodo = localStorage.getItem(`periodo${i}`);
        if (periodo) {
            document.getElementById(`periodo${i}`).innerText = periodo;
        }
    }
    cargarPeriodosAdicionales();
};

// Función para habilitar la edición al hacer clic derecho
function habilitarEdicion(event, periodoId, inputId) {
    event.preventDefault(); // Evitar el menú contextual predeterminado
    const h1 = document.getElementById(periodoId);
    const input = document.getElementById(inputId);

    // Alternar la visibilidad del h1 y el input
    if (input.style.display === "none") {
        input.style.display = "block";
        input.value = h1.innerText; // Cargar el texto actual en el input
        h1.style.display = "none"; // Ocultar el h1
        input.focus(); // Colocar el foco en el input

        // Agregar un evento para detectar la tecla "Enter"
        input.onkeypress = function (event) {
            if (event.key === "Enter") {
                guardarCambio(h1, input, periodoId);
            }
        };

        // Cerrar la edición si se hace clic fuera del input
        document.addEventListener('click', function (event) {
            if (!input.contains(event.target) && !h1.contains(event.target)) {
                cancelarEdicion(h1, input);
            }
        }, { once: true });
    }
}

function guardarCambio(h1, input, periodoId) {
    const nuevoValor = input.value.trim(); // Obtener el nuevo valor y eliminar espacios

    // Validar que el nuevo valor no esté vacío
    if (nuevoValor === "") {
        alert("El periodo no puede estar vacío."); // Mensaje de error
        input.focus(); // Volver a enfocar el input
        return;
    }

    // Guardar el nuevo valor
    h1.innerText = nuevoValor;
    try {
        localStorage.setItem(periodoId, nuevoValor); // Guardar en localStorage
        alert("Cambio guardado exitosamente."); // Mensaje de confirmación
    } catch (error) {
        console.error("Error al guardar en localStorage:", error);
        alert("Ocurrió un error al guardar el cambio.");
    }

    input.style.display = "none"; // Ocultar el input
    h1.style.display = "block"; // Mostrar el h1
}

function cancelarEdicion(h1, input) {
    input.style.display = "none"; // Ocultar el input
    h1.style.display = "block"; // Mostrar el h1
}

// Asignar el evento de clic derecho a cada título
for (let i = 1; i <= 4; i++) {
    const h1 = document.getElementById(`periodo${i}`);
    h1.addEventListener('contextmenu', function (event) {
        habilitarEdicion(event, `periodo${i}`, `inputPeriodo${i}`);
    });
}

// Función para agregar un nuevo periodo
document.getElementById('agregarPeriodo').addEventListener('click', function () {
    console.log("boton presionado");
    const nuevoId = Date.now(); // Usar timestamp para un ID único
    const nuevoPeriodoId = `periodo${nuevoId}`;
    const nuevoInputId = `inputPeriodo${nuevoId}`;
    const nuevoHref = `lic_sub_archivos_${nuevoId}.php`; // Crear un nuevo archivo PHP

    const nuevoDiv = document.createElement('div');
    nuevoDiv.className = 'primero';
    nuevoDiv.dataset.periodId = nuevoPeriodoId;
    nuevoDiv.dataset.inputId = nuevoInputId;

    const nuevoH1 = document.createElement('h1');
    nuevoH1.id = nuevoPeriodoId;
    nuevoH1.oncontextmenu = function () { return false; };
    nuevoH1.innerText = 'Nuevo Periodo';

    const nuevoInput = document.createElement('input');
    nuevoInput.type = 'text';
    nuevoInput.id = nuevoInputId;
    nuevoInput.placeholder = 'Modificar periodo';
    nuevoInput.style.display = 'none';

    nuevoDiv.appendChild(nuevoH1);
    nuevoDiv.appendChild(nuevoInput);

    const nuevoA = document.createElement('a');
    nuevoA.href = nuevoHref;
    nuevoA.appendChild(nuevoDiv);

    document.querySelector('.partes:last-child').appendChild(nuevoA);

    // Asignar el evento de clic derecho al nuevo título
    nuevoH1.addEventListener('contextmenu', function (event) {
        habilitarEdicion(event, nuevoPeriodoId, nuevoInputId);
    });

    // Guardar el nuevo periodo en localStorage
    localStorage.setItem(nuevoPeriodoId, 'Nuevo Periodo');

    // Crear el nuevo archivo PHP (esto se debe hacer en el servidor)
    // Aquí solo se simula la creación del archivo
    console.log(`Simulando creación de archivo: ${nuevoHref}`);
});

function cargarPeriodosAdicionales() {
    for (let i = 5; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('periodo') && !key.startsWith('periodo1') && !key.startsWith('periodo2') && !key.startsWith('periodo3') && !key.startsWith('periodo4')) {
            const periodo = localStorage.getItem(key);
            const periodoId = key;
            const inputId = `input${key.substring(7)}`;
            const nuevoHref = `lic_sub_archivos_${key.substring(7)}.php`;

            const nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'primero';
            nuevoDiv.dataset.periodId = periodoId;
            nuevoDiv.dataset.inputId = inputId;

            const nuevoH1 = document.createElement('h1');
            nuevoH1.id = periodoId;
            nuevoH1.oncontextmenu = function () { return false; };
            nuevoH1.innerText = periodo;

            const nuevoInput = document.createElement('input');
            nuevoInput.type = 'text';
            nuevoInput.id = inputId;
            nuevoInput.placeholder = 'Modificar periodo';
            nuevoInput.style.display = 'none';

            nuevoDiv.appendChild(nuevoH1);
            nuevoDiv.appendChild(nuevoInput);

            const nuevoA = document.createElement('a');
            nuevoA.href = nuevoHref;
            nuevoA.appendChild(nuevoDiv);

            document.querySelector('.partes:last-child').appendChild(nuevoA);

            // Asignar el evento de clic derecho al nuevo título
            nuevoH1.addEventListener('contextmenu', function (event) {
                habilitarEdicion(event, periodoId, inputId);
            });
        }
    }
}