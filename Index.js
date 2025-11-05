// Función para mostrar la pestaña (tab) de 'login' o 'registro'
// y actualizar la clase 'activo' de los botones.
// @param {string} tabId - El ID de la pestaña a mostrar ('login' o 'registro').
function mostrarTab(tabId) {
    // 1. Ocultar todas las pestañas de contenido
    const contenidos = document.querySelectorAll('.tab-contenido');
    contenidos.forEach(contenido => {
        contenido.classList.remove('activo');
    });

    // 2. Desactivar todos los botones
    const botones = document.querySelectorAll('.tab-btn');
    botones.forEach(boton => {
        boton.classList.remove('activo');
    });

    // 3. Mostrar la pestaña seleccionada
    const tabSeleccionada = document.getElementById(tabId);
    if (tabSeleccionada) {
        tabSeleccionada.classList.add('activo');
    }

    // 4. Activar el botón correspondiente
    const btnSeleccionado = document.getElementById('btn-' + tabId);
    if (btnSeleccionado) {
        btnSeleccionado.classList.add('activo');
    }
}

// Inicializar la vista al cargar la página.
// Por defecto, se muestra el tab de 'login' a menos que haya un error de registro.
window.onload = function() {
    // Implementar lógica para determinar qué tab mostrar inicialmente
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error') || urlParams.has('registro')) {
        // Si hay error o registro, mostrar el tab de registro
        mostrarTab('registro');
    } else {
        // Por defecto, mostrar el tab de login
        mostrarTab('login');
    }
};
// Nota: La función 'mostrarTab' debe ser llamada también por los botones.