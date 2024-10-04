document.addEventListener('DOMContentLoaded', () => {
  const elems = document.querySelectorAll('.icon');
  const path = window.location.pathname.split('/Prototipado_bcp_ciberseguridad/')[1];
  console.log(path);
  switch (path) {
    case '/activacion.php'| '/principal.php':
      elems[0].classList.add('active');
      break;
    case '/configuracion.php':
      elems[3].classList.add('active');
      break;
    default:
      elems[0].classList.add('active');
      break;
  }
});
