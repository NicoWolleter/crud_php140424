<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Establece la imagen de fondo */
        body {
            background-image: url('modelo/cafeteria.jpg'); /* Ruta de la imagen */
            background-size: cover; /* Cubre todo el contenido */
            background-position: center; /* Centra la imagen */
            height: 100vh; /* Establece la altura del fondo al 100% del viewport */
            margin: 0; /* Elimina el margen por defecto del cuerpo */
            padding: 0; /* Elimina el relleno por defecto del cuerpo */
        }

        .navbar {
            margin-bottom: 20px; /* Agrega un margen inferior a la barra de navegación */
            width: 100%; /* Hace que la barra de navegación ocupe todo el ancho */
        }

        /* Estilo para centrar la imagen verticalmente */
        .center-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px); /* Resta el tamaño de la barra de navegación */
        }

        .img-ubb {
            max-width: 100%; /* Asegura que la imagen no exceda el ancho del contenedor */
            max-height: 100%; /* Asegura que la imagen no exceda la altura del contenedor */
        }

        /* Estilo para el botón de cerrar sesión */
        .logout-button {
            margin-left: auto; /* Empuja el botón a la derecha */
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="main.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_inventario.php">Gestión de Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="proveedores.php">Gestión de Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Estadísticas</a>
                    </li>
                </ul>
            </div>
            <form class="d-flex">
                <button class="btn btn-outline-light logout-button" type="submit" formaction="logout.php">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <!-- Imagen -->
    <div class="center-image">
        <img src="https://media.biobiochile.cl/wp-content/uploads/2019/11/ubb.jpg" class="img-ubb" alt="Imagen UBB">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
