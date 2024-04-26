<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <!-- Agrega los estilos CSS del sistema -->
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
                        <a class="nav-link" href="agregar_productos.php">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas_registradas.php">Ventas registradas</a>
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

    <!-- Formulario para agregar productos -->
    <div class="container">
        <h1 class="text-center">Agregar Productos</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="realizar_cobro.php">
                    <div class="mb-3">
                        <label for="codigo_barra" class="form-label">Código de Barras</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="codigo_barra" id="codigo_barra">
                            <input type="number" class="form-control" name="cantidad" id="cantidad" value="1" min="1">
                            <button type="button" class="btn btn-primary" id="agregar_producto">Agregar Producto</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="productos" class="form-label">Productos</label>
                        <ul class="list-group" id="lista_productos"></ul>
                    </div>
                    <input type="hidden" name="productos" id="productos_input">
                    <button type="submit" class="btn btn-primary">Realizar Cobro</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Obtener los elementos del formulario
        const codigoBarraInput = document.getElementById('codigo_barra');
        const cantidadInput = document.getElementById('cantidad');
        const agregarProductoBtn = document.getElementById('agregar_producto');
        const listaProductos = document.getElementById('lista_productos');
        const productosInput = document.getElementById('productos_input');

        // Agregar evento al botón "Agregar Producto"
        agregarProductoBtn.addEventListener('click', function() {
            const codigoBarra = codigoBarraInput.value;
            const cantidad = cantidadInput.value;

            if (codigoBarra && cantidad) {
                const producto = `${codigoBarra},${cantidad}`;
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = producto;
                listaProductos.appendChild(li);
                codigoBarraInput.value = '';
                cantidadInput.value = '1';

                // Actualizar el valor del campo oculto de productos
                const productos = Array.from(listaProductos.children).map(li => li.textContent).join(';');
                productosInput.value = productos;
            }
        });
    </script>
</body>
</html>