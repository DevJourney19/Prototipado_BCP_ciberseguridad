document.addEventListener("DOMContentLoaded", () => {
	const elems = document.querySelectorAll(".icon");
	const path = window.location.pathname.split(
		"/Prototipado_bcp_ciberseguridad/view/",
	)[1];
	switch (path) {
		case "principal.php":
		case "activacion.php":
			elems[0].classList.add("active");
			break;
		case "configuracion.php":
			elems[3].classList.add("active");
			break;
		default:
			elems[3].classList.add("active");
			break;
	}
});
