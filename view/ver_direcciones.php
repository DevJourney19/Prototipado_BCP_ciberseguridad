<?php
include_once '../controller/ControllerEntradas.php';
// include_once 'config/Connection.php';
include_once '../dao/DaoDireccion.php'; 

$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

// Crear una instancia del DAO
$daoDireccion = new DaoDireccion();
$direcciones = $daoDireccion->obtenerTodasDirecciones(); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'fragmentos/head.php'; ?>
    <title>Rango de Horario y Ubicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/ver_direccion.css">
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
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $datos['id_direccion']; ?>" class="btn btn-editar me-3">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </a>
                                            <a href="ver_direcciones.php?id=<?= $datos['id_direccion'] ?>" onclick="return confirmar()" class="btn btn-danger">
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

        <!-- Aquí se mueven los modales fuera del <tbody> -->
        <?php foreach ($direcciones as $datos): ?>
        <!-- Modal para editar -->
        <div class="modal fade" id="editModal<?php echo $datos['id_direccion']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editar Dirección</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="php/controlador_modificar_direccion.php" method="post">
                            <input type="hidden" value="<?= $datos['id_direccion'] ?>" name="txtId">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección Exacta</label>
                                <input id="direccion" type="text" name="txtDireccion" value="<?php echo $datos['direccion_exacta']; ?>" required class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="rango" class="form-label">Rango GPS</label>
                                <select id="rango" name="txtRango" required class="form-select">
                                    <option value="" disabled>Seleccione un rango</option>
                                    <option value="10" <?php if($datos['rango_gps'] == 10) echo 'selected'; ?>>10 metros</option>
                                    <option value="20" <?php if($datos['rango_gps'] == 20) echo 'selected'; ?>>20 metros</option>
                                    <option value="30" <?php if($datos['rango_gps'] == 30) echo 'selected'; ?>>30 metros</option>
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
            return confirm("¿Desea eliminar el horario mencionado?");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
