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