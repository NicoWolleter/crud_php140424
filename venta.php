<?php
// Iniciar sesión y verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['correo_usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include 'modelo/conexion.php';

// Obtener el usuario de la sesión
$usuario = $_SESSION['correo_usuario'];

// Verificar si el formulario ha sido enviado y procesar la venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $productos = $_POST['productos'];
    $descuento_tipo = $_POST['descuento_tipo'];
    $descuento_valor = $_POST['descuento_valor'];
    $tipo_pago = $_POST['tipo_pago'];

    // Separar los productos y cantidades ingresados
    $productos_array = explode(';', $productos);

    foreach ($productos_array as $producto_info) {
        list($codigo_barra, $cantidad) = explode(',', $producto_info);

        // Procesar cada producto
        // Verificar si el producto existe en la tabla productos
        $sql_check_product = "SELECT * FROM productos WHERE codigo_barra = ?";
        $stmt_check_product = $conexion->prepare($sql_check_product);
        $stmt_check_product->bind_param("s", $codigo_barra);
        $stmt_check_product->execute();
        $result_check_product = $stmt_check_product->get_result();

        if ($result_check_product->num_rows == 1) {
            // El producto existe, proceder con la venta

            // Obtener información del producto
            $producto = $result_check_product->fetch_assoc();
            $precio_unitario = $producto['precio_unitario'];
            // Aplicar descuento si existe
            if ($descuento_tipo === 'porcentaje') {
                $total_venta = $cantidad * $precio_unitario * (1 - ($descuento_valor / 100));
            } else {
                $total_venta = $cantidad * $precio_unitario - $descuento_valor;
            }

            // Obtener la cantidad actual del producto
            $sql_get_quantity = "SELECT cantidad FROM productos WHERE codigo_barra = ?";
            $stmt_get_quantity = $conexion->prepare($sql_get_quantity);
            $stmt_get_quantity->bind_param("s", $codigo_barra);
            $stmt_get_quantity->execute();
            $result_get_quantity = $stmt_get_quantity->get_result();

            if ($result_get_quantity->num_rows == 1) {
                $row = $result_get_quantity->fetch_assoc();
                $cantidad_actual = $row['cantidad'];
                $nueva_cantidad = $cantidad_actual - $cantidad;

                // Actualizar la cantidad del producto en la base de datos
                $sql_update_quantity = "UPDATE productos SET cantidad = ? WHERE codigo_barra = ?";
                $stmt_update_quantity = $conexion->prepare($sql_update_quantity);
                $stmt_update_quantity->bind_param("is", $nueva_cantidad, $codigo_barra);
                $stmt_update_quantity->execute();

                // Insertar la venta en la tabla ventas
                $sql_insert_venta = "INSERT INTO ventas (codigo_barra, cantidad, descuento_tipo, descuento_valor, tipo_pago, usuario, total_venta) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert_venta = $conexion->prepare($sql_insert_venta);
                $stmt_insert_venta->bind_param("sisssds", $codigo_barra, $cantidad, $descuento_tipo, $descuento_valor, $tipo_pago, $usuario, $total_venta);
                $stmt_insert_venta->execute();
            } else {
                // Producto no encontrado
                $error_message = "El producto seleccionado no existe. Por favor, selecciona un producto válido.";
            }
        } else {
            // El producto no existe en la tabla productos
            $error_message = "El producto seleccionado no existe. Por favor, selecciona un producto válido.";
        }
    }

    // Redirigir o mostrar un mensaje de éxito
    header("Location: ventas_registradas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venta</title>
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
                        <a class="nav-link" href="venta.php">Ventas</a>
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
    <!-- Formulario para realizar la venta -->
    <div class="container">
        <h1 class="text-center">Realizar Venta</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="productos" class="form-label">Productos</label>
                        <textarea class="form-control" name="productos" rows="4" required></textarea>
                        <small class="form-text text-muted">Ingrese los códigos de barras de los productos y sus cantidades separados por coma (por ejemplo: codigo1,cantidad1;codigo2,cantidad2).</small>
                    </div>
                    <div class="mb-3">
                        <label for="descuento_tipo" class="form-label">Tipo de Descuento</label>
                        <select class="form-select" name="descuento_tipo" required>
                            <option value="porcentaje">Porcentaje</option>
                            <option value="valor">Valor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descuento_valor" class="form-label">Valor del Descuento</label>
                        <input type="number" class="form-control" name="descuento_valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                        <select class="form-select" name="tipo_pago" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="redcompra">Redcompra</option>
                            <option value="junaeb">Junaeb</option>
                        </select>
                    </div>
                    <?php if (isset($error_message)): ?>
                        <p class="text-danger"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Realizar Venta</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Imagen -->
    <div class="center-image">
        <img src="https://media.biobiochile.cl/wp-content/uploads/2019/11/ubb.jpg" class="img-ubb" alt="Imagen UBB">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
