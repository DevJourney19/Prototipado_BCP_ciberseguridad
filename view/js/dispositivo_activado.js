async function controlarFormulario(event) {
    event.preventDefault(); // Agregar paréntesis

    try {
        const response = await fetch('../php/activar_seguridad.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        // Verificar si la respuesta es exitosa
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json(); // Obtener la respuesta como JSON
        console.log(data); // Imprimir la respuesta para depuración

        // Redirigir solo si los datos son válidos
        if (data.status === 'no registrado' && data.status === 'registrado') { // Suponiendo que el servidor devuelve un campo 'success'
            window.location.href = "./activacion.php";
        } else {
            console.error('Error en la activación:', data.message); // Manejo de errores
        }
        
    } catch (error) {
        console.error('Error al establecer la sesión: ', error);
    }
}