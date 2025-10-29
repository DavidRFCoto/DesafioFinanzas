function mostrarTab(tab) {
    // Ocultar todos los tabs
    document.querySelectorAll('.tab-contenido').forEach(el => {
        el.classList.remove('activo');
    });
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('activo');
    });

    // Mostrar el tab seleccionado
    document.getElementById(tab).classList.add('activo');
    event.target.classList.add('activo');
}

