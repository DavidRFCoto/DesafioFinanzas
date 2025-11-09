function mostrarTab(tabId) {
    // Ocultar todos los tabs con una animación suave
    document.querySelectorAll('.tab-contenido').forEach(tab => {
        $(tab).fadeOut(200);
    });
    
    // Mostrar el tab seleccionado con una animación suave
    setTimeout(() => {
        document.querySelectorAll('.tab-contenido').forEach(tab => {
            if (tab.id === tabId) {
                $(tab).fadeIn(200);
            }
        });
    }, 200);
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