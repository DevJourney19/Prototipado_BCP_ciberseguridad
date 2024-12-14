
let btn_enviar_correo = document.querySelector(".header .btn.enviar-emails");
// Todos los checkbox recorridos por el foreach
let checkbox_seleccionado = document.querySelectorAll(".checkbox_seleccionado");

//Si se selecciona el checkbox de algun registro de la tabla
document.querySelectorAll(".checkbox_seleccionado").forEach(checkbox => {
    checkbox.addEventListener("change", () => {
        marcarCheckBox();
        actualizarSeleccionarTodo();
        evidenciar_cambios();
    })
});

function marcarCheckBox() {
    // Verificar si al menos uno de los checkboxes está marcado
    let algunoMarcado = Array.from(checkbox_seleccionado).some(checkbox => checkbox.checked);
    if (algunoMarcado) {
        btn_enviar_correo.classList.add("ver_btn_enviar_email");
    } else {
        btn_enviar_correo.classList.remove("ver_btn_enviar_email");
    }
}

//Al presionar en el checkbox para seleccionar todos los usuarios
function seleccionar_todo() {
    let seleccionar_todo_cb = document.getElementById("select-all");
    let checkboxes = document.querySelectorAll(".checkbox_seleccionado");

    checkboxes.forEach(checkbox => {
        checkbox.checked = seleccionar_todo_cb.checked;
    });
    marcarCheckBox();
    obtenerCantidadSeleccionados();
    evidenciar_cambios();
}
// Función para actualizar el estado del checkbox "Seleccionar todo"
function actualizarSeleccionarTodo() {
    let checkboxes = document.querySelectorAll(".checkbox_seleccionado");
    let seleccionar_todo_cb = document.getElementById("select-all");

    // Verificar si todos los checkboxes están seleccionados
    let todosSeleccionados = Array.from(checkboxes).every(checkbox => checkbox.checked);

    // Si todos están seleccionados, marcar "Seleccionar todo", si no desmarcarlo
    seleccionar_todo_cb.checked = todosSeleccionados;
}
//Mostrar los elementos seleccionados
function evidenciar_cambios() {
    let cantidad = obtenerCantidadSeleccionados();
    let mostrar_cantidad = document.getElementById("selected-count");
    mostrar_cantidad.innerHTML = cantidad;
}
function obtenerCantidadSeleccionados() {
    // Obtener todos los checkboxes con la clase .checkbox_seleccionado
    let checkboxes = document.querySelectorAll(".checkbox_seleccionado");

    // Filtrar los checkboxes que están seleccionados (checked = true)
    let seleccionados = Array.from(checkboxes).filter(checkbox => checkbox.checked);
    // Devolver la cantidad de checkboxes seleccionados
    return seleccionados.length;
}

//Codigo enfocado en el modal
document.getElementById('openModal').onclick = function () {
    document.getElementById('customModal').style.display = 'flex';
};

document.querySelector('.close').onclick = function () {
    document.getElementById('customModal').style.display = 'none';
};

window.onclick = function (event) {
    if (event.target == document.getElementById('customModal')) {
        document.getElementById('customModal').style.display = 'none';
    }
};

//Modal
document.getElementById('openModal').onclick = function () {
    document.getElementById('customModal').style.display = 'flex';
};

document.querySelector('.close').onclick = function () {
    document.getElementById('customModal').style.display = 'none';
};

//Hacer que cuando se haga clic en el customModal se cierre el modal, sin hacer clic en el div principal
window.onclick = function (event) {
    if (event.target == document.getElementById('customModal')) {
        document.getElementById('customModal').style.display = 'none';
    }
};

//Imagen en pantalla completa
function showFullscreen(event) {
    // Obtener el modal y la imagen seleccionada
    const modal = document.getElementById('fullscreen-modal');
    const fullscreenImage = document.getElementById('fullscreen-image');

    // Actualizar la fuente de la imagen en el modal
    fullscreenImage.src = event.target.src;

    // Mostrar el modal
    modal.style.display = 'flex';

    // Cerrar el modal cuando se haga clic
    modal.addEventListener('click', () => {
        modal.style.display = 'none';
    });
}

function obtenerCorreosSeleccionados() {
    // Seleccionar todos los checkboxes marcados con name="correo[]"
    const elementos = document.querySelectorAll('[name="correo[]"]');
    // Crear un array con los valores de los checkboxes marcados
    const correos = Array.from(elementos).map(e => e.value);
    return correos;
}

function obtenerIdUsuariosServicioActivado() {
    const obtener = document.querySelectorAll('[name="ids[]"]');

    const ids = Array.from(obtener).map(e => e.value);
    return ids;
}

async function enviarCorreo(event) {
    event.preventDefault();
    let nombre = document.getElementById("admin_nombre").dataset.value;
    console.log(nombre);
    let correos = obtenerCorreosSeleccionados();
    console.log(correos);

    let opcion = event.target.getAttribute("data-opcion");

    let posicion_icono = document.querySelector(".msg_especifico_correo");
    let icono_carga = document.createElement("div");
    icono_carga.classList.add('fa-solid', 'fa-spinner', 'fa-spin', 'fa-xl', 'icono_cargando');
    posicion_icono.appendChild(icono_carga);

    let response = await fetch("../controller/admin_proceso_env_correo.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            correos: correos,
            opcion: opcion,
            nombre: nombre
        }),
    });

    icono_carga.classList.remove('fa-solid', 'fa-spinner', 'fa-spin', 'fa-xl');
    const data = await response.json();
    console.log(data);
    console.log("Correos es " + correos);
    if (data.success && data.success.length > 0) {
        alert("Operación exitosa");
    } else {
        alert("Operación fallida");
    }

    document.getElementById('customModal').style.display = 'none';
}

//Correo especifico

let opcionn = document.querySelectorAll("[data-especifico]");

opcionn.forEach(t => {
    t.addEventListener("click", async function (event) {
        console.log("helloo ;)");
        let opcion = event.target.getAttribute("data-especifico");
        let correos = obtenerCorreosSeleccionados();
        let nombre = document.getElementById("admin_nombre").dataset.value;
        let ids = obtenerIdUsuariosServicioActivado();
        console.log(ids);

        let posicion_icono = document.querySelector(".msg_especifico_correo");
        let icono_carga = document.createElement("div");
        icono_carga.classList.add('fa-solid', 'fa-spinner', 'fa-spin', 'fa-xl', 'icono_cargando');

        posicion_icono.appendChild(icono_carga);

        let response = await fetch("../controller/admin_proceso_env_especific_correo.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                opcion: opcion,
                objetos: ids.map((dato, index) => ({
                    id: dato,
                    correo: correos[index]
                })),
                nombre: nombre,
            })
        });
        //el response.text() puede generar que de el alert de operación fallida
        icono_carga.classList.remove('fa-solid', 'fa-spinner', 'fa-spin', 'fa-xl');
        const data = await response.json();
        console.log(data);
        console.log("Los correos son: " + correos);
        if (data.success && data.success.length > 0) {
            alert("Operación exitosa");
        } else {
            alert("Operación fallida");
        }


    });
});


