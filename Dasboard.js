function mostrarSeccion(seccionId) {
    // Ocultar todos los tabs
    const tabs = document.querySelectorAll('.tab-contenido');
    tabs.forEach(tab => {
        tab.classList.remove('activo');
    });

    // Mostrar la sección seleccionada
    const seccion = document.getElementById(seccionId);
    if (seccion) {
        seccion.classList.add('activo');
    }
}