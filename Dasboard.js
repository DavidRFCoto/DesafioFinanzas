/**
 * Muestra la sección del dashboard solicitada y oculta las demás.
 * @param {string} idSeccion - El ID del div a mostrar ('ver-entradas', 'ver-salidas', 'balance').
 */
function mostrarSeccion(idSeccion) {
    // 1. Ocultar todos los divs que tienen la clase 'tab-contenido'
    const secciones = document.querySelectorAll('.tab-contenido');
    secciones.forEach(seccion => {
        seccion.style.display = 'none';
    });

    // 2. Mostrar la sección solicitada por su ID
    const seccionActiva = document.getElementById(idSeccion);
    if (seccionActiva) {
        seccionActiva.style.display = 'block';
    }
}

// 3. Ocultar todas las secciones al cargar la página (Inicialización)
document.addEventListener('DOMContentLoaded', () => {
    const secciones = document.querySelectorAll('.tab-contenido');
    secciones.forEach(seccion => {
        seccion.style.display = 'none';
    });
    
    // Opcional: Mostrar una sección por defecto al iniciar, si lo deseas
    // Por ejemplo, para mostrar el balance por defecto:
    // mostrarSeccion('balance'); 
});

/*function mostrarSeccion(idSeccion) {
    // 1. Ocultar todos los divs que tienen la clase 'tab-contenido'
    const secciones = document.querySelectorAll('.tab-contenido');
    secciones.forEach(seccion => {
        seccion.style.display = 'none';
    });

    // 2. Mostrar la sección solicitada por su ID
    const seccionActiva = document.getElementById(idSeccion);
    if (seccionActiva) {
        seccionActiva.style.display = 'block';
    }
}

// Oculta todas las secciones al cargar la página para que solo se vea el balance principal.
    document.addEventListener('DOMContentLoaded', () => {
        const secciones = document.querySelectorAll('.tab-contenido');
        secciones.forEach(seccion => {
            seccion.style.display = 'none';
        });
    });*/