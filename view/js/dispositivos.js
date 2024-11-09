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
        idSeleccionado = checkbox.closest('.caja').id; // Obtiene el id del div más cercano con clase 'caja'
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
        console.log(idSeleccionado);
        const caja = document.getElementById(idSeleccionado); //HGcemos la unión entre la caja y el checkbox
        if (caja) {

            const dispositivoss = JSON.parse(localStorage.getItem('nuevo_dispositivo'));

            const dispositivoEncontrado = dispositivoss.find(d => d.id === Number(idSeleccionado));

            const estado_actualizado = {
                id: idSeleccionado,
                tipo: dispositivoEncontrado.tipo,
                dip: dispositivoEncontrado.dip,
                pais: dispositivoEncontrado.pais,
                ciudad: dispositivoEncontrado.ciudad,
                estado: 'activado',
                fecha: dispositivoEncontrado.fecha
            }

            actualizacion_local_storage(idSeleccionado, estado_actualizado);

            try {
                const response = await fetch("../controller/ControllerDispositivo.php?action=acciones", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id_dispositivo: idSeleccionado,
                        accion: 'activar'
                    })
                });

                const data = await response.json();
                console.log(idSeleccionado);
            } catch (error) {
                console.error('Error al establecer la sesión: ', error);
            };
        }
    }
}
//VERIFICAR !!
function actualizacion_local_storage(idSeleccionado, estado_actualizado) {
    let dispositivos = JSON.parse(localStorage.getItem('nuevo_dispositivo'));
    dispositivos = dispositivos.map(t => {
        if (t.id === Number(idSeleccionado)) {
            //Actualiza el estado del localStorage
            return { ...t, ...estado_actualizado };
        }
        return t;
    });
    localStorage.setItem('nuevo_dispositivo', JSON.stringify(dispositivos));
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
        console.log("aceptado");
        eliminarCajaSeleccionada();
    } else {
        console.log("cancelado");
    }
};
//__--__

async function eliminarCajaSeleccionada() {
    if (idSeleccionado) {
        console.log(idSeleccionado);
        const caja = document.getElementById(idSeleccionado); //HGcemos la unión entre la caja y el checkbox
        if (caja) {
            caja.remove(); // Eliminar la caja del DOM
            let dispositivos = JSON.parse(localStorage.getItem('nuevo_dispositivo'));
            if (dispositivos) {
                dispositivos = dispositivos.filter(t => t.id !== Number(idSeleccionado));
                localStorage.setItem('nuevo_dispositivo', JSON.stringify(dispositivos));
            }

            //CORREGIR
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
                console.log(idSeleccionado);
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
    historial.addEventListener('click',  () => {
        window.location.href = './consulta_dispositivos.php';
    });
}

document.addEventListener('DOMContentLoaded',  () =>{
    //Se puso así para cuando se reciba un mensaje de success se pueda volver a llamar a la función 
    agregando_solicitudes_html();
});

async function dispositivo() {
    try {
        const response = await fetch('../controller/ControllerDispositivo.php?action=mostrar');
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
};


//CONSULTAR DISPOSITIVOS //SE AGREGAN LOS DISPOSITIVOS A CONSULTA DISPOSITIVO, LOS CUALES SON LOS QUE HAN INGRESADO EL CODIGO SEA CORRECTO O INCORRECTO
async function agregando_solicitudes_html() {
    try {
        const data = await dispositivo();
        //Filtrar los dispositivos según el estado (de esta manera nos ahorramos usar el where de la bd, ahorrando lineas de codigo)
        const dispositivos_filtrados = data.filter(dispositivo =>
            dispositivo.estado === 'en_proceso_si' || dispositivo.estado === 'en_proceso_no'
        );

        const tabla_dis = document.getElementById('tabla_dispositivos');

        tabla_dis.innerHTML = '';

        // biome-ignore lint/complexity/noForEach: <explanation>
        dispositivos_filtrados.forEach(dispositivo => {
            const estado_dis = dispositivo.estado === 'en_proceso_si' ? 'Si' : 'No';

            tabla_dis.innerHTML += `
                <tr>
                    <td>${dispositivo.tipo}</td>
                    <td>${dispositivo.dip}</td>
                    <td>${dispositivo.pais}</td>
                    <td>${dispositivo.ciudad}</td>
                    <td>${estado_dis}</td>
                    <td>${dispositivo.fecha}</td>
                    <td><button class="botoncito_accion_permitir accion-boton" data-id="${dispositivo.id}" data-accion="permitir">Permitir</button></td>
                    <td><button class="botoncito_accion_eliminar accion-boton" data-id="${dispositivo.id}" data-accion="eliminar">Eliminar</button></td>
                    <td><button class="botoncito_accion_bloquear accion-boton" data-id="${dispositivo.id}" data-accion="bloquear">Bloquear</button></td>
                </tr>`;
        });
    } catch (error) {
        console.error('Error al obtener dispositivos:', error);
    };

    //Añadiendo los listeners a los botones | Para evitar bucles o reiteraciones del action event por cada botón realizado
    manejadorBoton();

}

async function manejadorBoton() {
    const botonesAccion = document.querySelectorAll('.accion-boton');
    // biome-ignore lint/complexity/noForEach: <explanation>
    botonesAccion.forEach(boton => {
        boton.addEventListener('click', async function () {
            const id_dispositivo = this.getAttribute('data-id'); // Obtener el ID del dispositivo
            localStorage.setItem('id_dispositivo', id_dispositivo);
            const accion = this.getAttribute('data-accion'); // Obtener la acción
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

                const data = await response.json(); //problema detected
                const resultado_div = document.getElementById('resultado');

                if (data.status === 'success') {
                    resultado_div.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    await agregando_solicitudes_html(); //Actualizar la tabla
                    //htmleando(accion);

                    if (accion === 'permitir') {
                        const id_comparar = this.getAttribute('data-id');

                        const info = await dispositivo();

                        if (id_dispositivo === id_comparar) {
                            //filtremos info
                            //Quizás se tenga que hacer un filtro para el dispositivo de usuario //Quizás se tenga que hacer como una consulta especifica...
                            const informacion = info.filter(t => t.estado === 'seguro');

                            console.log(`La informacion es: ${informacion}`);

                            //let local = JSON.parse(localStorage.getItem('nuevo_dispositivo'));
                            //local.push(informacion);
                            //Se van a agregar después de haber agregado al primero que es el dispositivo activado
                            localStorage.setItem('nuevo_dispositivo', JSON.stringify(informacion));
                            window.location.href = './dispositivos.php';
                        }
                    }//fin del if
                } else {
                    resultado_div.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('resultado').innerHTML = '<div class="alert alert-danger">Error al realizar la acción.</div>';
            };
        })
    })
};