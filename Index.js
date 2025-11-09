function mostrarTab(tabId) {
    // Ocultar todos los tabs con una animación suave
    document.querySelectorAll('.tab-contenido').forEach(tab => {
        $(tab).fadeOut(200);
        tab.classList.remove('activo');
    });
    
    // Mostrar el tab seleccionado con una animación suave
    setTimeout(() => {
        const tabSeleccionado = document.getElementById(tabId);
        if (tabSeleccionado) {
            $(tabSeleccionado).fadeIn(200);
            tabSeleccionado.classList.add('activo');
        }
    }, 200);
}

// Inicializar la vista al cargar la página
window.onload = function() {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    
    // Mostrar el tab apropiado según los parámetros
    if (urlParams.has('registro_error')) {
        // Solo mostrar registro si hay un error específico de registro
        mostrarTab('registro');
    } else {
        // En cualquier otro caso (incluyendo errores de login), mostrar el tab de login
        mostrarTab('login');
    }
};
// Nota: La función 'mostrarTab' debe ser llamada también por los botones.