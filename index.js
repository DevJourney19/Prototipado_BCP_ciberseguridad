document.addEventListener('DOMContentLoaded', function () {
    const grafico_1 = document.getElementById("grafico_1").getContext("2d");
    const satisfaccion = ['Muy bueno', 'Bueno', 'Neutro', 'Malo', 'Muy Malo'];
    const numeros = [100, 90, 30, 60, 10];
    const myChart = new Chart(grafico_1, {
        type: "pie",
        data: {
            labels: satisfaccion,
            datasets: [{
                //label: "buenas",
                data: numeros,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],
                borderWidth: 1.5
            }]
        }, options: {
            
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'  // Color del texto de la leyenda
                    }
                }
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const grafico_2 = document.getElementById("grafico_2").getContext("2d");
    const valor = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const numeros = [100, 40, 50, 30, 40, 200, 30, 40, 50, 80, 40, 90];
    const numeros2 = [10, 30, 20, 60, 80, 100, 240, 140, 60, 40, 20, 90];
    const myChart = new Chart(grafico_2, {
        type: "line",
        data: {
            labels: valor,
            datasets: [{
                label: "Ingresos",
                data: numeros,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],

                borderWidth: 1.5,
                fill: true
            },
            {
                label: "Registros",
                data: numeros2,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],
                borderWidth: 1.5,
                fill: true
            }
            ]
        }, options: {
            scales: {

                x: {
                    ticks: {
                        color: '#ffffff'  // Color de los labels en el eje X
                    }
                },
                y: {
                    ticks: {
                        color: '#ffffff'  // Color de los labels en el eje Y
                    }
                },
                r: {
                    ticks: {
                        color: '#ffffff',  // Cambiar el color del texto de los ticks (dentro del radar)
                        backdropColor: 'rgba(255, 255, 255, 0)',  // Para que no tenga fondo detrás del texto
                    },
                    pointLabels: {
                        color: '#ffffff',  // Cambiar el color del texto en los bordes del radar
                        font: {
                            size: 14  // Tamaño de fuente opcional
                        }
                    }
                }

            },
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'  // Color del texto de la leyenda
                    }
                }
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const grafico_3 = document.getElementById("grafico_3").getContext("2d");
    const satisfaccion = ['Ganancias', 'Metas'];
    const numeros = [6000, 10000];
    const myChart = new Chart(grafico_3, {
        type: "doughnut",
        data: {
            labels: satisfaccion,
            datasets: [{
                //label: "buenas",
                data: numeros,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],
                borderWidth: 1.5
            }]
        }, options: {

            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'  // Color del texto de la leyenda
                    }
                }
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const grafico_4 = document.getElementById("grafico_4").getContext("2d");
    const valor = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const numeros = [1000, 400, 500, 900, 450, 1500, 360, 460, 50, 860, 406, 106];
    const numeros2 = [580, 310, 202, 610, 820, 100, 240, 140, 610, 420, 220, 910];
    const myChart = new Chart(grafico_4, {
        type: "radar",
        data: {
            labels: valor,
            datasets: [{
                label: "2023",
                data: numeros,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],

                borderWidth: 1.5,
                fill: false
            },
            {
                label: "2024",
                data: numeros2,
                backgroundColor: [
                    'rgba(224, 132, 22, 0.2)',
                    'rgba(98, 175, 125, 0.2)',
                    'rgba(49, 172, 196, 0.2)',
                    'rgba(152, 70, 255, 0.2)',
                    'rgba(209, 59, 59, 0.2)'
                ],
                borderColor: [
                    'rgba(224, 132, 22, 1)',
                    'rgba(98, 175, 125, 1)',
                    'rgba(49, 172, 196, 1)',
                    'rgba(152, 70, 255, 1)',
                    'rgba(209, 59, 59, 1)'
                ],
                borderWidth: 1.5,
                fill: false
            }]
        }, options: {
            scales: {
                r: {
                    ticks: {
                        color: '#ffffff',  // Cambiar el color del texto de los ticks (dentro del radar)
                        backdropColor: 'rgba(255, 255, 255, 0)',  // Para que no tenga fondo detrás del texto
                    },
                    pointLabels: {
                        color: '#ffffff',  // Cambiar el color del texto en los bordes del radar
                        font: {
                            size: 14  // Tamaño de fuente opcional
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'  // Color del texto de la leyenda
                    }
                }
            }
        }
    })
});