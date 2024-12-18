<?php

include_once '/app/controller/ControllerEntradas.php';
include_once '/app/controller/ControllerDireccion.php';

$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

$daoDireccion = new DaoDireccion();
$direcciones = $daoDireccion->obtenerTodasDirecciones($_SESSION['id_seguridad']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php'; ?>
    <title>Rango de Horario y Ubicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/ver_direccion.css">
    <link rel="stylesheet" href="css/modal_direccion.css">
</head>

<body>
    <header><?php include 'fragmentos/nav.php'; ?></header>
    <main class="contenedor-ubicaciones">

        <div class="container mt-4">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Dirección exacta</th>
                            <th>Rango GPS</th>
                            <th>Fecha de Creación</th>
                            <th>Hora de Creación</th>
                            <th colspan="2" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($direcciones)) {
                            echo "<tr><td colspan='7' class='text-center'>No se encontraron resultados.</td></tr>";
                        } else {
                            foreach ($direcciones as $datos) {
                        ?>
                                <tr>
                                    <td><?php echo $datos['id_direccion']; ?></td>
                                    <td><?php echo $datos['direccion_exacta']; ?></td>
                                    <td><?php echo $datos['rango_gps']; ?></td>
                                    <td><?php echo $datos['fecha_configuracion']; ?></td>
                                    <td><?php echo $datos['hora_configuracion']; ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?php echo $datos['id_direccion']; ?>"
                                                class="btn btn-editar me-3">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </a>
                                            <a href="/app/controller/ControllerDireccion.php?action=eliminar&id=<?= $datos['id_direccion'] ?>"
                                                onclick="return confirmar()" class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modales para editar -->
        <?php foreach ($direcciones as $datos): ?>
            <div class="modal fade" id="editModal<?php echo $datos['id_direccion']; ?>" tabindex="-1"
                aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Editar Dirección</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/app/controller/ControllerDireccion.php?action=modificar" method="post">
                                <input type="hidden" name="txtId" value="<?= $datos['id_direccion'] ?>">
                                <input type="hidden" name="longitud" id="longitud" value="<?= $datos['longitud'] ?>">
                                <input type="hidden" name="latitud" id="latitud" value="<?= $datos['latitud'] ?>">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label d-flex gap-2 justify-content-start">
                                        <i class="fa-solid fa-map-location-dot"></i> Dirección Exacta (Calle y Distrito)
                                    </label>
                                    <div class="input-container">
                                        <input type="text" id="locationInput" placeholder="Busca una dirección" value="<?= $datos['direccion_exacta'] ?>"
                                            oninput="autocompleteAddress(this.value)" name="txtdireccion" autocomplete="off" />
                                        <button type="button" onclick="getLocation()">Ubicación Actual</button>
                                    </div>
                                    <ul id="suggestions"></ul>

                                </div>
                                <div class="mb-3">
                                    <label for="rango" class="form-label">Rango GPS</label>
                                    <select id="rango" name="txtRango" required class="form-select">
                                        <option value="50" <?= $datos['rango_gps'] == 50 ? 'selected' : '' ?>>50 metros
                                        </option>
                                        <option value="100" <?= $datos['rango_gps'] == 100 ? 'selected' : '' ?>>100 metros
                                        </option>
                                        <option value="200" <?= $datos['rango_gps'] == 200 ? 'selected' : '' ?>>200 metros
                                        </option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-editar" name="btnModificar">Modificar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="botones">
            <button class="btn btn-salir" onclick="window.location.href = 'horario_ubicacion.php'">Regresar</button>
        </div>
    </main>
    <script>
        function confirmar() {
            return confirm("¿Desea eliminar la dirección mencionada?");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="js/ubicacion_direccion.js"></script>
</body>

</html>