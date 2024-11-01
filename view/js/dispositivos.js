const modal = document.getElementById("vinculo");
const modalDos = document.getElementById("desvinculo");

// Función para abrir el modal
const openModal = () => {
    modal.showModal();
};

// Función para cerrar el modal
const closeModal = () => {
    modal.close();
};
// Función para abrir el modal
const openModalDos = () => {
    modalDos.showModal();
};

// Función para cerrar el modal
const closeModalDos = () => {
    modalDos.close();
};

//En caso para ver los resultados de los equipos que han querido intentar ingresar a su cuenta
const historial = document.getElementById("historial");
if (historial) {
    historial.addEventListener('click', function () {
        window.location.href = './consulta_dispositivos.php';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    //Se puso así para cuando se reciba un mensaje de success se pueda volver a llamar a la función 
    actualizar_dispositivos();
});


async function actualizar_dispositivos() {
    try {
        const response = await fetch('../php/obtener_dispositivos.php');
        const data = await response.json();

        //Filtrar los dispositivos según el estado (de esta manera nos ahorramos usar el where de la bd, ahorrando lineas de codigo)
        const dispositivos_filtrados = data.filter(dispositivo =>
            dispositivo.estado === 'en_proceso_si' || dispositivo.estado === 'en_proceso_no'
        );

        const tabla_dis = document.getElementById('tabla_dispositivos');
        tabla_dis.innerHTML = '';

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
    //Leer los botones para hacerlos asíncronos
    const botonesAccion = document.querySelectorAll('.accion-boton');
    botonesAccion.forEach(boton => {
        boton.addEventListener('click', async function () {
            const id_dispositivo = this.getAttribute('data-id'); // Obtener el ID del dispositivo
            const accion = this.getAttribute('data-accion'); // Obtener la acción
            try {
                // Realizar la solicitud AJAX usando fetch
                const response = await fetch('../php/acciones_dispositivo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id_dispositivo: id_dispositivo,
                        accion: accion
                    })
                })
                const data = await response.json();
                const resultado_div = document.getElementById('resultado');

                if (data.status === 'success') {
                    resultado_div.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    actualizar_dispositivos();
                } else {
                    resultado_div.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('resultado').innerHTML = '<div class="alert alert-danger">Error al realizar la acción.</div>';
            };
        });
    })

};



