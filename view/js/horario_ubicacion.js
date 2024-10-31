document.addEventListener('DOMContentLoaded', () => {
    // Obtener elementos para el modal 1 (horario)
    const botonRegistrarRango = document.getElementById('boton-registrar-rango');
    const modalHorario = document.getElementById('modal-horario');
    const botonCerrarModalHorario = modalHorario.querySelector('.boton-naranja');

    // Obtener elementos para el modal 2 (ubicación)
    const botonRegistrarUbicacion = document.getElementById('boton-registrar-direccion');
    const modalUbicacion = document.getElementById('modal-ubicacion');
    const botonCerrarModalUbicacion = modalUbicacion.querySelector('.boton-naranja');

    // Función para mostrar el modal de horario
    botonRegistrarRango.addEventListener('click', () => {
        modalHorario.classList.add('show');
    });

    // Función para cerrar el modal de horario
    botonCerrarModalHorario.addEventListener('click', () => {
        modalHorario.classList.remove('show');
    });

    // Función para mostrar el modal de ubicación
    botonRegistrarUbicacion.addEventListener('click', () =>{
        modalUbicacion.classList.add('show');
    });

    // Función para cerrar el modal de ubicación
    botonCerrarModalUbicacion.addEventListener('click', () =>{
        modalUbicacion.classList.remove('show');
    });
});