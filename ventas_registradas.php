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

// Consulta SQL para obtener los registros de ventas con detalles de productos
$sql_ventas_productos = "
SELECT ventas.id_venta, ventas.cantidad, ventas.descuento_tipo, ventas.descuento_valor, ventas.tipo_pago, ventas.usuario, ventas.total_venta, ventas.fecha_hora, ventas.estado, productos.producto AS nombre_producto, productos.precio_venta, productos.productos_vendidos
FROM ventas
INNER JOIN productos ON ventas.codigo_barra = productos.codigo_barra
";

// Ejecutar la consulta
$resultado_ventas_productos = $conexion->query($sql_ventas_productos);

$total_productos_vendidos = 0; // Inicializar contador de productos vendidos

while ($fila = $resultado_ventas_productos->fetch_assoc()) {
    $total_productos_vendidos += $fila['cantidad']; // Sumar la cantidad de productos vendidos
}

// Obtener la cantidad actual de productos vendidos
$sql_get_quantity = "SELECT SUM(productos_vendidos) AS total_productos_vendidos FROM productos";
$stmt_get_quantity = $conexion->prepare($sql_get_quantity);
$stmt_get_quantity->execute();
$result_get_quantity = $stmt_get_quantity->get_result();

if ($result_get_quantity->num_rows == 1) {
    $row = $result_get_quantity->fetch_assoc();
    $total_productos_vendidos = $row['total_productos_vendidos'];
}
?>

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

    <div class="container">
        <h1 class="text-center p-3">Registros de Ventas</h1>

        <p>Total de productos vendidos: <?php echo $total_productos_vendidos; ?></p>

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
                SELECT ventas.id_venta, ventas.cantidad, ventas.descuento_tipo, ventas.descuento_valor, ventas.tipo_pago, ventas.usuario, ventas.total_venta, ventas.fecha_hora, ventas.estado, productos.producto AS nombre_producto, productos.precio_venta
                FROM ventas
                INNER JOIN productos ON ventas.codigo_barra = productos.codigo_barra
                ";

                // Ejecutar la consulta
                $resultado_ventas_productos = $conexion->query($sql_ventas_productos);

                while ($fila = $resultado_ventas_productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_venta']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?> (Cantidad: <?php echo $fila['cantidad']; ?>, Precio Unitario: $<?php echo $fila['precio_venta']; ?>)</td>
                        <td><?php echo $fila['fecha_hora']; ?></td>
                        <td><?php echo $fila['tipo_pago']; ?></td>
                        <td><?php echo $fila['usuario']; ?></td>
                        <td>$<?php echo $fila['total_venta']; ?></td>
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