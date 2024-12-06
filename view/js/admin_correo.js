
let btn_enviar_correo = document.querySelector(".header .btn.enviar-emails");
console.log(btn_enviar_correo);
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
