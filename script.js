/**
 * * @param {string} tabId - El ID del tab a mostrar ('login' o 'registro').
 */
function mostrarTab(tabId) {
    // 1. Ocultar todos los tabs de contenido
    document.querySelectorAll('.tab-contenido').forEach(el => {
        el.classList.remove('activo');
    });
    
    // 2. Desactivar todos los botones de tab
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('activo');
    });

    // 3. Mostrar la sección de contenido seleccionada
    const seccion = document.getElementById(tabId);
    if (seccion) {
        seccion.classList.add('activo');
    }
    
    // 4. Activar el botón correspondiente (usando su ID)
    const btnActivo = document.getElementById('btn-' + tabId);
    if (btnActivo) {
        btnActivo.classList.add('activo');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('registro_error')) {
        mostrarTab('registro');
    } else {
        mostrarTab('login');
    }
});