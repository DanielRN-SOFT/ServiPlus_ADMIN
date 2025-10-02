fetch("../controllers/datos_grafico_cargo.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.nombreCargo);
    const valores = data.map((item) => item.cantidad);

    const colores = [
      "rgba(255, 99, 132, 0.5)",
      "rgba(54, 162, 235, 0.5)",
      "rgba(255, 206, 86, 0.5)",
      "rgba(75, 192, 192, 0.5)",
      "rgba(153, 102, 255, 0.5)",
      "rgba(255, 159, 64, 0.5)",
    ];

    const ctx = document.getElementById("graficoCargos").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Cantidad de empleados por cargos",
            data: valores,
            backgroundColor: colores,
            borderColor: colores.map((c) => c.replace("0.5", "1")), // borde más fuerte
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  })

  .catch((error) => console.error("Error al cargar los datos: ", error));
