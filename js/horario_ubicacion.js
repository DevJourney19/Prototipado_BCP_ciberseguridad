document.addEventListener('DOMContentLoaded', function () {
    // Obtener elementos para el modal 1 (horario)
    const botonRegistrarRango = document.getElementById('boton-registrar-rango');
    const modalHorario = document.getElementById('modal-horario');
    const botonCerrarModalHorario = modalHorario.querySelector('.boton-naranja');

    // Obtener elementos para el modal 2 (ubicación)
    const botonRegistrarUbicacion = document.getElementById('boton-registrar-direccion');
    const modalUbicacion = document.getElementById('modal-ubicacion');
    const botonCerrarModalUbicacion = modalUbicacion.querySelector('.boton-naranja');

    // Función para mostrar el modal de horario
    botonRegistrarRango.addEventListener('click', function () {
        modalHorario.classList.add('show');
    });

    // Función para cerrar el modal de horario
    botonCerrarModalHorario.addEventListener('click', function () {
        modalHorario.classList.remove('show');
    });

    // Función para mostrar el modal de ubicación
    botonRegistrarUbicacion.addEventListener('click', function () {
        modalUbicacion.classList.add('show');
    });

    // Función para cerrar el modal de ubicación
    botonCerrarModalUbicacion.addEventListener('click', function () {
        modalUbicacion.classList.remove('show');
    });
});