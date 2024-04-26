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

// Inicializar variables
$productos = '';
$descuento_tipo = 'porcentaje';
$descuento_valor = 0;
$tipo_pago = 'efectivo';
$error_message = '';

// Verificar si el formulario ha sido enviado y procesar la venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $productos = $_POST['productos'];
    $descuento_tipo = isset($_POST['descuento_tipo']) ? $_POST['descuento_tipo'] : 'porcentaje';
    $descuento_valor = isset($_POST['descuento_valor_porcentaje']) ? $_POST['descuento_valor_porcentaje'] : (isset($_POST['descuento_valor_monto']) ? $_POST['descuento_valor_monto'] : 0);
    $tipo_pago = isset($_POST['tipo_pago']) ? $_POST['tipo_pago'] : 'efectivo';

    // Separar los productos y cantidades ingresados
    $productos_array = explode(';', $productos);

    $total_venta = 0; // Variable para almacenar el total de la venta

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
            $producto = $result_check_product->fetch_assoc();

            // Obtener información del producto
            $precio_venta = $producto['precio_venta'];

            // Aplicar descuento si existe
            if ($descuento_tipo === 'porcentaje') {
                $subtotal = $cantidad * $precio_venta * (1 - ($descuento_valor / 100));
            } else {
                $subtotal = $cantidad * $precio_venta - $descuento_valor;
            }

            // Obtener la cantidad actual del producto
            $sql_get_quantity = "SELECT cantidad, productos_vendidos FROM productos WHERE codigo_barra = ?";
            $stmt_get_quantity = $conexion->prepare($sql_get_quantity);
            $stmt_get_quantity->bind_param("s", $codigo_barra);
            $stmt_get_quantity->execute();
            $result_get_quantity = $stmt_get_quantity->get_result();

            if ($result_get_quantity->num_rows == 1) {
                $row = $result_get_quantity->fetch_assoc();
                $cantidad_actual = $row['cantidad'];
                $productos_vendidos_actual = $row['productos_vendidos'];
                $nueva_cantidad = $cantidad_actual - $cantidad;
                $nuevos_productos_vendidos = $productos_vendidos_actual + $cantidad;

                // Actualizar la cantidad y productos vendidos del producto en la base de datos
                $sql_update_product = "UPDATE productos SET cantidad = ?, productos_vendidos = ? WHERE codigo_barra = ?";
                $stmt_update_product = $conexion->prepare($sql_update_product);
                $stmt_update_product->bind_param("iis", $nueva_cantidad, $nuevos_productos_vendidos, $codigo_barra);
                $stmt_update_product->execute();

                // Insertar la venta en la tabla ventas
                $sql_insert_venta = "INSERT INTO ventas (codigo_barra, cantidad, descuento_tipo, descuento_valor, tipo_pago, usuario, total_venta) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert_venta = $conexion->prepare($sql_insert_venta);
                $stmt_insert_venta->bind_param("sisssdd", $codigo_barra, $cantidad, $descuento_tipo, $descuento_valor, $tipo_pago, $usuario, $subtotal);
                $stmt_insert_venta->execute();

                $total_venta += $subtotal; // Sumar el subtotal al total de la venta
            } else {
                // Producto no encontrado
                $error_message = "El producto seleccionado no existe. Por favor, selecciona un producto válido.";
            }
        } else {
            // El producto no existe en la tabla productos
            $error_message = "El producto seleccionado no existe. Por favor, selecciona un producto válido.";
        }
    }

    // Actualizar el total de la venta en la tabla ventas
    $sql_update_total_venta = "UPDATE ventas SET total_venta = ? WHERE usuario = ? ORDER BY id_venta DESC LIMIT 1";
    $stmt_update_total_venta = $conexion->prepare($sql_update_total_venta);
    $stmt_update_total_venta->bind_param("ds", $total_venta, $usuario);
    $stmt_update_total_venta->execute();

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
    <title>Realizar Cobro</title>
    <!-- Agrega los estilos CSS del sistema -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Estilos CSS */
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
    <!-- Formulario para realizar el cobro -->
    <div class="container">
        <h1 class="text-center">Realizar Cobro</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="productos" class="form-label">Productos</label>
                        <textarea class="form-control" name="productos" id="productos" rows="4" readonly><?php echo $_POST['productos']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="total_venta" class="form-label">Total a Cobrar</label>
                        <input type="text" class="form-control" name="total_venta" id="total_venta" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                        <select class="form-select" name="tipo_pago" id="tipo_pago" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="redcompra">Redcompra</option>
                            <option value="junaeb">Junaeb</option>
                        </select>
                    </div>
                    <div class="mb-3" id="contenedor_efectivo" style="display: none;">
                        <label for="efectivo" class="form-label">Efectivo</label>
                        <input type="number" class="form-control" name="efectivo" id="efectivo" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3" id="contenedor_vuelto" style="display: none;">
                        <label for="vuelto" class="form-label">Vuelto</label>
                        <input type="text" class="form-control" name="vuelto" id="vuelto" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="descuento_tipo" class="form-label">Tipo de Descuento</label>
                        <select class="form-select" name="descuento_tipo" id="descuento_tipo" required>
                            <option value="porcentaje">Porcentaje</option>
                            <option value="valor">Valor</option>
                        </select>
                    </div>
                    <div class="mb-3" id="contenedor_descuento_porcentaje" style="display: none;">
                        <label for="descuento_valor_porcentaje" class="form-label">Valor del Descuento (Porcentaje)</label>
                        <input type="number" class="form-control" name="descuento_valor_porcentaje" min="0" max="100" step="0.01" required>
                    </div>
                    <div class="mb-3" id="contenedor_descuento_valor" style="display: none;">
                        <label for="descuento_valor_monto" class="form-label">Valor del Descuento (Monto)</label>
                        <input type="number" class="form-control" name="descuento_valor_monto" min="0" step="0.01" required>
                    </div>
                    <?php if (isset($error_message)): ?>
                        <p class="text-danger"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Finalizar Venta</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Imagen -->
    <div class="center-image">
        <img src="https://media.biobiochile.cl/wp-content/uploads/2019/11/ubb.jpg" class="img-ubb" alt="Imagen UBB">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Obtener los elementos del formulario
        const totalVentaInput = document.getElementById('total_venta');
        const tipoPagoSelect = document.getElementById('tipo_pago');
        const contenedorEfectivo = document.getElementById('contenedor_efectivo');
        const contenedorVuelto = document.getElementById('contenedor_vuelto');
        const efectivoInput = document.getElementById('efectivo');
        const vueltoInput = document.getElementById('vuelto');
        const descuentoTipoSelect = document.getElementById('descuento_tipo');
        const contenedorDescuentoPorcentaje = document.getElementById('contenedor_descuento_porcentaje');
        const contenedorDescuentoValor = document.getElementById('contenedor_descuento_valor');
        const descuentoValorPorcentajeInput = document.getElementById('descuento_valor_porcentaje');
        const descuentoValorMontoInput = document.getElementById('descuento_valor_monto');

        // Función para obtener el precio de un producto a través de AJAX
        function obtenerPrecioProducto(codigoBarra) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const precio = parseFloat(xhr.responseText);
                            resolve(precio);
                        } else {
                            reject('Error al obtener el precio del producto');
                        }
                    }
                };
                xhr.open('GET', `obtener_precio.php?codigo_barra=${codigoBarra}`, true);
                xhr.send();
            });
        }

        // Calcular el total de la venta al cargar la página
        document.addEventListener('DOMContentLoaded', async function() {
            const productosArray = document.getElementById('productos').value.split(';');
            let totalVenta = 0;

            for (const producto of productosArray) {
                const [codigoBarra, cantidad] = producto.split(',');
                const precio = await obtenerPrecioProducto(codigoBarra);
                const subtotal = precio * cantidad;
                totalVenta += subtotal;
            }

            totalVentaInput.value = totalVenta.toFixed(2);
        });

        // Agregar evento al select de tipo de pago
        tipoPagoSelect.addEventListener('change', function() {
            if (tipoPagoSelect.value === 'efectivo') {
                contenedorEfectivo.style.display = 'block';
                contenedorVuelto.style.display = 'block';
            } else {
                contenedorEfectivo.style.display = 'none';
                contenedorVuelto.style.display = 'none';
            }
        });

        // Agregar evento al input de efectivo
        efectivoInput.addEventListener('input', function() {
            const totalVenta = parseFloat(totalVentaInput.value);
            const efectivo = parseFloat(efectivoInput.value);

            if (!isNaN(totalVenta) && !isNaN(efectivo)) {
                const vuelto = efectivo - totalVenta;
                vueltoInput.value = vuelto.toFixed(2);
            }
        });

        // Agregar evento al select de tipo de descuento
        descuentoTipoSelect.addEventListener('change', function() {
            if (descuentoTipoSelect.value === 'porcentaje') {
                contenedorDescuentoPorcentaje.style.display = 'block';
                contenedorDescuentoValor.style.display = 'none';
            } else {
                contenedorDescuentoPorcentaje.style.display = 'none';
                contenedorDescuentoValor.style.display = 'block';
            }
        });
    </script>
</body>
</html>