const controlarFormulario = () => {
  const nombre = document.getElementById('nombre_activacion').value;
  const correo = document.getElementById('correo_activacion').value;
  const telefono = document.getElementById('telefono_activacion').value;
  const checkbox = document.getElementById('checkbox_activacion').checked;
  const error = document.getElementById('error_activacion');
  const alertaExito = document.getElementById('alerta_exito_activacion');

  error.innerHTML = '';

  if (nombre === '' || correo === '' || telefono === '' || !checkbox) {
    error.innerHTML = 'Por favor, complete todos los campos.';
    return;
  }

  if (telefono.length < 9 && telefono.match(/^[0-9]+$/)) {
    error.innerHTML = 'El teléfono debe tener al menos 9 dígitos.';
    return;
  }

  document.getElementById("button_activacion").disabled = true;

  alertaExito.classList.remove('close');

  setTimeout(() => {
    alertaExito.classList.add('close');
  }, 3000);

  document.getElementById('nombre_activacion').value = '';
  document.getElementById('correo_activacion').value = '';
  document.getElementById('telefono_activacion').value = '';
  document.getElementById('checkbox_activacion').checked = false;
}