$(function () {
    'use strict'

    // Activar los tooltips de Bootstrap
    $('[data-toggle="tooltip"]').tooltip()

    // Manejar el colapso del sidebar
    $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault()
        if (window.innerWidth > 768) {
            $('body').toggleClass('sidebar-collapse')
        } else {
            $('body').toggleClass('sidebar-open')
        }
    })

    // Destacar el menú activo basado en la URL actual
    let currentPath = window.location.pathname
    $('.nav-sidebar .nav-link').each(function() {
        if ($(this).attr('href') === currentPath.split('/').pop()) {
            $(this).addClass('active')
        }
    })

    // Animación suave para las info-boxes
    $('.info-box').each(function(index) {
        $(this).delay(index * 100).animate({
            opacity: 1,
            top: 0
        }, 500)
    })
})