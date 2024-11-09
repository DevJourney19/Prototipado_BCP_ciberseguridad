document.addEventListener('DOMContentLoaded', ()=> {
    const horaInicioInput = document.getElementById('hora-inicio-nuevo');
    const horaFinInput = document.getElementById('hora-fin-nuevo');
    const mensajeError = document.getElementById('avisoError');
    const btnRegistrar = document.getElementById('boton-registrar-rango');

    function validarHorarios() {
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;

        if (!horaInicio || !horaFin) {
            mensajeError.textContent = "Debe rellenar todos los campos.";
            btnRegistrar.disabled = true; 
            return; 
        }

        const inicioMinutos = convertirMinutos(horaInicio);
        const finMinutos = convertirMinutos(horaFin);

        if (inicioMinutos >= finMinutos) {
            mensajeError.textContent = "La hora de inicio debe ser anterior a la hora de fin.";
            btnRegistrar.disabled = true; 
        } else {
            mensajeError.textContent = ""; 
            btnRegistrar.disabled = false; 
        }
    }

    function convertirMinutos(hora) {
        const [h, m] = hora.split(':').map(Number);
        return h * 60 + m; // Convertir a minutos para comparación
    }

    horaInicioInput.addEventListener('change', validarHorarios);
    horaFinInput.addEventListener('change', validarHorarios);
});