const getDataSatisfaccion = async () => {
  const date = new Date();
  const mesSelect = document.getElementById("satisfaccion-mes");
  const mes = mesSelect ? mesSelect.value : (new Date().getMonth() + 1);
  const response = await fetch(
    `/app/controller/ControllerEstadisticas.php?action=emocion&mes=${mes}&anio=${date.getFullYear()}`
  );
  const data = await response.json();
  return data;
};

document.addEventListener("DOMContentLoaded", async () => {
  const mesSelect = document.getElementById("satisfaccion-mes");
  const mensajeNoData = document.getElementById("mensaje-satisfaccion");
  let myChart;

  const updateChart = async () => {
    try {
      const lista = await getDataSatisfaccion(mesSelect.value);
      const grafico_1 = document.getElementById("grafico_1").getContext("2d");
      const satisfaccion = [];
      const numeros = [];
      for (const i of lista) {
        satisfaccion.push(i.estado);
        numeros.push(i.cantidad);
      }

      if (myChart) {
        myChart.destroy();
      }

      if (lista.length === 0) {
        mensajeNoData.style.display = "block";
        mensajeNoData.innerHTML = "No hay datos para mostrar";
        return;
      } else {
        mensajeNoData.style.display = "none";
      }

      myChart = new Chart(grafico_1, {
        type: "pie",
        data: {
          labels: satisfaccion,
          datasets: [
            {
              data: numeros,
              backgroundColor: [
                "rgba(224, 132, 22, 0.2)",
                "rgba(98, 175, 125, 0.2)",
                "rgba(49, 172, 196, 0.2)",
                "rgba(152, 70, 255, 0.2)",
                "rgba(209, 59, 59, 0.2)",
              ],
              borderColor: [
                "rgba(224, 132, 22, 1)",
                "rgba(98, 175, 125, 1)",
                "rgba(49, 172, 196, 1)",
                "rgba(152, 70, 255, 1)",
                "rgba(209, 59, 59, 1)",
              ],
              borderWidth: 1.5,
            },
          ],
        },
        options: {
          plugins: {
            legend: {
              labels: {
                color: "#ffffff", // Color del texto de la leyenda
              },
            },
          },
        },
      });
    } catch (error) {
      console.error("Error updating chart:", error);
    }
  };

  mesSelect.addEventListener("change", updateChart);

  // Inicializar el gráfico con el mes seleccionado por defecto
  updateChart();
});

const getRegistros = async () => {
  const date = new Date();
  const response = await fetch(
    "../controller/ControllerEstadisticas.php?action=registros"
  );
  const data = await response.json();
  return data;
};

document.addEventListener("DOMContentLoaded", async () => {
  const lista = await getRegistros();
  // si no retorna nada de otros meses se reemplaza por 0
  const registros = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  for (const i of lista) {
    registros[i.mes - 1] = i.cantidad;
  }
  const grafico_2 = document.getElementById("grafico_2").getContext("2d");
  const valor = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Setiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];
  const myChart = new Chart(grafico_2, {
    type: "line",
    data: {
      labels: valor,
      datasets: [
        {
          label: "Registros",
          data: registros,
          backgroundColor: [
            "rgba(224, 132, 22, 0.2)",
            "rgba(98, 175, 125, 0.2)",
            "rgba(49, 172, 196, 0.2)",
            "rgba(152, 70, 255, 0.2)",
            "rgba(209, 59, 59, 0.2)",
          ],
          borderColor: [
            "rgba(224, 132, 22, 1)",
            "rgba(98, 175, 125, 1)",
            "rgba(49, 172, 196, 1)",
            "rgba(152, 70, 255, 1)",
            "rgba(209, 59, 59, 1)",
          ],
          borderWidth: 1.5,
          fill: true,
        },
      ],
    },
    options: {
      scales: {
        x: {
          ticks: {
            color: "#ffffff", // Color de los labels en el eje X
          },
        },
        y: {
          ticks: {
            color: "#ffffff", // Color de los labels en el eje Y
          },
        },
        r: {
          ticks: {
            color: "#ffffff", // Cambiar el color del texto de los ticks (dentro del radar)
            backdropColor: "rgba(255, 255, 255, 0)", // Para que no tenga fondo detrás del texto
          },
          pointLabels: {
            color: "#ffffff", // Cambiar el color del texto en los bordes del radar
            font: {
              size: 14, // Tamaño de fuente opcional
            },
          },
          min: 0,
          max: Math.max(...registros),
        },
      },
      plugins: {
        legend: {
          labels: {
            color: "#ffffff", // Color del texto de la leyenda
          },
        },
      },
    },
  });
});

const getGanacias = async () => {
  const date = new Date();
  const response = await fetch(
    `/app/controller/ControllerEstadisticas.php?action=ganancias&mes=${date.getMonth() + 1
    }&anio=${date.getFullYear()}`
  );
  const data = await response.json();
  return data;
};

document.addEventListener("DOMContentLoaded", async () => {
  const grafico_3 = document.getElementById("grafico_3").getContext("2d");
  const satisfaccion = ["Metas"];
  const numeros = [10000];
  const ganacias = await getGanacias();
  satisfaccion.push("Ganancias");
  numeros.push(ganacias[0].cantidad * 10);
  const myChart = new Chart(grafico_3, {
    type: "doughnut",
    data: {
      labels: satisfaccion,
      datasets: [
        {
          //label: "buenas",
          data: numeros,
          backgroundColor: [
            "rgba(224, 132, 22, 0.2)",
            "rgba(98, 175, 125, 0.2)",
            "rgba(49, 172, 196, 0.2)",
            "rgba(152, 70, 255, 0.2)",
            "rgba(209, 59, 59, 0.2)",
          ],
          borderColor: [
            "rgba(224, 132, 22, 1)",
            "rgba(98, 175, 125, 1)",
            "rgba(49, 172, 196, 1)",
            "rgba(152, 70, 255, 1)",
            "rgba(209, 59, 59, 1)",
          ],
          borderWidth: 1.5,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          labels: {
            color: "#ffffff", // Color del texto de la leyenda
          },
        },
      },
    },
  });
});

const getReportes = async (year) => {
  const response = await fetch(
    `/app/controller/ControllerEstadisticas.php?action=reportes&anio=${year}`
  );
  const data = await response.json();
  return data;
};

document.addEventListener("DOMContentLoaded", async () => {
  const thisYear = new Date().getFullYear();
  const registroActual = await getReportes(thisYear);
  const registroAnterior = await getReportes(thisYear - 1);
  const grafico_4 = document.getElementById("grafico_4").getContext("2d");
  const valor = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Setiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];
  const numeros = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  const numeros2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

  for (const i of registroActual) {
    numeros[i.mes - 1] = i.cantidad;
  }

  for (const i of registroAnterior) {
    numeros2[i.mes - 1] = i.cantidad;
  }

  const myChart = new Chart(grafico_4, {
    type: "radar",
    data: {
      labels: valor,
      datasets: [
        {
          label: thisYear,
          data: numeros,
          backgroundColor: [
            "rgba(224, 132, 22, 0.2)",
            "rgba(98, 175, 125, 0.2)",
            "rgba(49, 172, 196, 0.2)",
            "rgba(152, 70, 255, 0.2)",
            "rgba(209, 59, 59, 0.2)",
          ],
          borderColor: ["rgba(224, 132, 22, 1)"],

          borderWidth: 1.5,
          fill: false,
        },
        {
          label: thisYear - 1,
          data: numeros2,
          backgroundColor: [
            "rgba(224, 132, 22, 0.2)",
            "rgba(98, 175, 125, 0.2)",
            "rgba(49, 172, 196, 0.2)",
            "rgba(152, 70, 255, 0.2)",
            "rgba(209, 59, 59, 0.2)",
          ],
          borderColor: ["rgba(98, 175, 125, 1)"],
          borderWidth: 1.5,
          fill: false,
        },
      ],
    },
    options: {
      scales: {
        r: {
          ticks: {
            color: "#ffffff", // Cambiar el color del texto de los ticks (dentro del radar)
            backdropColor: "rgba(255, 255, 255, 0)", // Para que no tenga fondo detrás del texto
          },
          pointLabels: {
            color: "#ffffff", // Cambiar el color del texto en los bordes del radar
            font: {
              size: 14, // Tamaño de fuente opcional
            },
          },
        },
      },
      plugins: {
        legend: {
          labels: {
            color: "#ffffff", // Color del texto de la leyenda
          },
        },
      },
    },
  });
});

const mes = document.querySelectorAll(".mes");
const anio = document.querySelectorAll(".anio");

const meses = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Setiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];
const currentYear = new Date().getFullYear();

for (const m of mes) {
  const mesNumero = Number.parseInt(new Date().getMonth() + 1);
  m.innerHTML = meses[mesNumero - 1];
}

for (const a of anio) {
  a.innerHTML = currentYear;
}

let mesSelect = document.getElementById("satisfaccion-mes");
if (mesSelect) {
  mesSelect.value = new Date().getMonth() + 1;
}
