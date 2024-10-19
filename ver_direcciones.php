<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'fragmentos/head.php' ?>
    <title>Rango de Horario y Ubicacion</title>
    <link rel="stylesheet" href="horario_ubicacion.css">
</head>

<body>
    <header>
        <?php include 'fragmentos/nav.php' ?>
    </header>
    <main class="contenedor-ubicaciones">
        <div class="titulo">Lista de Ubicaciones Registradas</div>
        <ul class="lista-localizacion">
            <li class="localizacion">
                <i class="fas fa-map-marker-alt"></i>
                <span class="localizacion-texto">Las Flores 156, SJL</span>
                <i class="fas fa-trash delete-icon"></i>
            </li>
            <li class="localizacion">
                <i class="fas fa-map-marker-alt"></i>
                <span class="localizacion-texto">Las Rosales 156, SMP</span>
                <i class="fas fa-trash delete-icon"></i>
            </li>
            <li class="localizacion">
                <i class="fas fa-map-marker-alt"></i>
                <span class="localizacion-texto">Av. Mariscal 156, SJL</span>
                <i class="fas fa-trash delete-icon"></i>
            </li>
        </ul>
        <div class="botones">
            <button class="boton-azul">Salir</button>
        </div>
    </main>
</body>

</html>