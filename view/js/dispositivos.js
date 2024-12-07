const modal = document.getElementById("vinculo");
const modalDos = document.getElementById("desvinculo");

// Función para abrir el modal
const openModal = () => {
    modal.showModal();
};

let idSeleccionado = null;

//Cuando se haga click en el checkbox
function handleCheckboxClick(checkbox) {
    if (checkbox.checked) {
        // Guardar el id del div (caja) que contiene el checkbox
        const caja_seleccionada = checkbox.closest('.caja');
        if (caja_seleccionada) {
            idSeleccionado = caja_seleccionada.getAttribute("data-id");
            console.log(idSeleccionado);
        }
    }

}
// Función para cerrar el modal //DISPOSITIVO PRINCIPAL
const closeModal = (estado) => {
    modal.close();
    if (estado === 'aceptar') {
        dispositivo_principal();
    }
};

const dispositivo_principal = async () => {

    if (idSeleccionado) {
        const caja = document.getElementById(idSeleccionado); //Hacemos la unión entre la caja y el checkbox

        if (caja) {
            try {
                const response = await fetch("../controller/ControllerDispositivo.php?action=acciones", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id_dispositivo: idSeleccionado,
                        accion: 'principal'
                    })
                });

                const data = await response.json();
                location.reload();
            } catch (error) {
                console.error('Error al establecer la sesión: ', error);
            };
        }
    }
}

// Función para abrir el modal
const openModalDos = () => {
    modalDos.showModal();

    //Creo que aqui se debe obtener el id
};

idSeleccionado = null;
// Función para cerrar el modal //DESVINCULAR DISPOSITIVO
const closeModalDos = async (estado) => {
    modalDos.close();
    if (estado === 'aceptar') {
        eliminarCajaSeleccionada();
        console.log("aceptado");
        console.log(idSeleccionado);
    } else {
        console.log("cancelado");
    }
};
//__--__

async function eliminarCajaSeleccionada() {
    if (idSeleccionado) {
        console.log(idSeleccionado);
        const caja = document.querySelector(`[data-id="${idSeleccionado}"]`); //HGcemos la unión entre la caja y el checkbox

        if (caja) {
            caja.remove(); // Eliminar la caja del DOM

            try {
                const response = await fetch("../controller/ControllerDispositivo.php?action=deleteDispo", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        idSeleccionado: idSeleccionado
                    })
                });

                const data = await response.json();
                location.reload();
            } catch (error) {
                console.error('Error al establecer la sesión: ', error);
            };
        }
    }
}

//--__--
//En caso para ver los resultados de los equipos que han querido intentar ingresar a su cuenta
const historial = document.getElementById("historial");
if (historial) {
    historial.addEventListener('click', () => {
        window.location.href = './consulta_dispositivos.php';
    });
}

async function manejadorBoton() {
    const botonesAccion = document.querySelectorAll('.accion-boton');
    for (const boton of botonesAccion) {
        boton.addEventListener('click', async function () {
            const id_dispositivo = this.getAttribute('data-id');
            const accion = this.getAttribute('data-accion');
            try {
                // Realizar la solicitud AJAX usando fetch
                const response = await fetch('../controller/ControllerDispositivo.php?action=acciones', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id_dispositivo: id_dispositivo,
                        accion: accion
                    })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    alert(data.message);

                    // Selecciona la fila correspondiente en la tabla
                    const fila = document.querySelector(`tr[data-id="${id_dispositivo}"]`);
                    //Hacer que el producto desaparezca de consulta_dispositivo, debido a la falta de actualización del servidor
                    fila.remove();

                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert("Error al realizar la acción");
            };
        });
    }
};
document.addEventListener('DOMContentLoaded', () => {
    manejadorBoton();
});
