const locationIQToken = "pk.95650cc04867a361ea8990fdd052af6b";
const longitud = document.getElementById("longitud");
const latitud = document.getElementById("latitud");

function autocompleteAddress(input) {
  const suggestions = document.getElementById("suggestions");
  if (input.length === 0) {
    suggestions.style.display = "none";
    return;
  }

  const url = `https://us1.locationiq.com/v1/search.php?key=${locationIQToken}&q=${encodeURIComponent(
    input
  )}&format=json&limit=5`;

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error en la red: ${response.statusText}`);
      }
      return response.json();
    })
    .then((data) => {
      suggestions.innerHTML = "";
      // biome-ignore lint/complexity/noForEach: <explanation>
      data.forEach((item) => {
        const li = document.createElement("li");
        li.textContent = item.display_name;
        li.onclick = () => {
          document.getElementById("locationInput").value = item.display_name;
          longitud.value = item.lon;
          latitud.value = item.lat;
          suggestions.style.display = "none";
        };
        suggestions.appendChild(li);
      });
      suggestions.style.display = data.length > 0 ? "block" : "none";
    })
    .catch((error) => {
      console.error("Error en el autocompletado:", error);
    });
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        const url = `https://us1.locationiq.com/v1/reverse.php?key=${locationIQToken}&lat=${lat}&lon=${lon}&format=json`;

        fetch(url)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`Error en la red: ${response.statusText}`);
            }
            return response.json();
          })
          .then((data) => {
            document.getElementById("locationInput").value = data.display_name;
            longitud.value = lon;
            latitud.value = lat;
          })
          .catch((error) => {
            console.error("Error al obtener la dirección:", error);
          });
      },
      () => {
        alert(
          "No se pudo obtener la ubicación. Verifica los permisos de ubicación."
        );
      }
    );
  } else {
    alert("La geolocalización no está soportada por este navegador.");
  }
}
