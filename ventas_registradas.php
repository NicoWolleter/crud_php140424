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
    $codigo_barra = $_POST['codigo_barra'];
    $cantidad = $_POST['cantidad'];
    $descuento_tipo = $_POST['descuento_tipo'];
    $descuento_valor = $_POST['descuento_valor'];
    $tipo_pago = $_POST['tipo_pago'];

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

        // Insertar la venta en la tabla ventas
        $sql_insert_venta = "INSERT INTO ventas (codigo_barra, cantidad, descuento_tipo, descuento_valor, tipo_pago, usuario, total_venta) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_venta = $conexion->prepare($sql_insert_venta);
        $stmt_insert_venta->bind_param("sisssds", $codigo_barra, $cantidad, $descuento_tipo, $descuento_valor, $tipo_pago, $usuario, $total_venta);
        $stmt_insert_venta->execute();

        // Obtener la cantidad actual del producto
        $cantidad_actual = $producto['cantidad'];
        $nueva_cantidad = $cantidad_actual - $cantidad;

        // Actualizar la cantidad del producto en la base de datos
        $sql_update_quantity = "UPDATE productos SET cantidad = ? WHERE codigo_barra = ?";
        $stmt_update_quantity = $conexion->prepare($sql_update_quantity);
        $stmt_update_quantity->bind_param("is", $nueva_cantidad, $codigo_barra);
        $stmt_update_quantity->execute();

        // Redirigir o mostrar un mensaje de éxito
        header("Location: ventas_registradas.php");
        exit();
    } else {
        // El producto no existe en la tabla productos
        $error_message = "El producto seleccionado no existe. Por favor, selecciona un producto válido.";
    }
}

// Consulta SQL para obtener los registros de ventas con detalles de productos
$sql_ventas_productos = "
SELECT ventas.id_venta, ventas.cantidad, ventas.descuento_tipo, ventas.descuento_valor, ventas.tipo_pago, ventas.usuario, ventas.total_venta, ventas.fecha_hora, ventas.estado, productos.producto AS nombre_producto, productos.precio_unitario
FROM ventas
INNER JOIN productos ON ventas.codigo_barra = productos.codigo_barra
";


// Ejecutar la consulta
$resultado_ventas_productos = $conexion->query($sql_ventas_productos);
?>

<!-- Resto del código HTML -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css"> <!--dataTables CSS-->
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

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Agrega un fondo semi-transparente a los contenidos para mejorar la legibilidad */
            padding: 20px; /* Añade relleno para separar los contenidos del fondo */
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

    <div class="container">
        <h1 class="text-center p-3">Registros de Ventas</h1>

        <table class="table" id="tablaVentas"> <!-- Agrega el ID "tablaVentas" a la tabla -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Productos</th>
                    <th>Fecha y Hora</th>
                    <th>Tipo de Pago</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "modelo/conexion.php";

                // Consulta SQL para obtener los registros de ventas con detalles de productos
                $sql_ventas_productos = "
                SELECT ventas.id_venta, ventas.cantidad, ventas.descuento_tipo, ventas.descuento_valor, ventas.tipo_pago, ventas.usuario, ventas.total_venta, ventas.fecha_hora, ventas.estado, productos.producto AS nombre_producto, productos.precio_unitario
                FROM ventas
                INNER JOIN productos ON ventas.codigo_barra = productos.codigo_barra
                ";

                // Ejecutar la consulta
                $resultado_ventas_productos = $conexion->query($sql_ventas_productos);

                while ($fila = $resultado_ventas_productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_venta']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?> (Cantidad: <?php echo $fila['cantidad']; ?>, Precio Unitario: $<?php echo $fila['precio_unitario']; ?>)</td>
                        <td><?php echo $fila['fecha_hora']; ?></td>
                        <td><?php echo $fila['tipo_pago']; ?></td>
                        <td><?php echo $fila['usuario']; ?></td>
                        <td><?php echo $fila['total_venta']; ?></td>
                        <td><?php echo $fila['estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Agrega jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agrega DataTables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializa la tabla con DataTables
            $('#tablaVentas').DataTable({
                "pagingType": "simple_numbers", // Muestra solo los números de paginación
                "pageLength": 5 // Establece la cantidad máxima de elementos por página
            });
        });
    </script>
</body>
</html>
