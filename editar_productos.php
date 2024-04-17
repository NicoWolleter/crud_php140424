<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/52820557f8.js" crossorigin="anonymous"></script>
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

        .container-fluid {
            background-color: rgba(255, 255, 255, 0.9); /* Agrega un fondo semi-transparente a los contenidos para mejorar la legibilidad */
            padding: 20px; /* Añade relleno para separar los contenidos del fondo */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center p-3">Editar Producto</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">

            <?php
            // Verificar si se ha recibido el id_producto
            if(isset($_GET['id'])) {
                // Incluir el archivo de conexión a la base de datos
                include "modelo/conexion.php";

                // Obtener el id_producto de la URL
                $id_producto = $_GET['id'];

                // Obtener los datos del producto de la base de datos
                $sql = $conexion->query("SELECT * FROM productos WHERE id_producto = $id_producto");
                $datos = $sql->fetch_object();

                // Verificar si se ha enviado el formulario de edición
                if(isset($_POST['boton_editar']) && $_POST['boton_editar'] === "ok") {
                    // Obtener los datos del formulario
                    $producto = $_POST['producto'];
                    $proveedor = $_POST['proveedor'];
                    $precio_adq = $_POST['precio_adq'];
                    $precio_venta = $_POST['precio_venta'];
                    $fecha_ingreso = $_POST['fecha_ingreso'];
                    $fecha_caducidad = $_POST['fecha_caducidad'];
                    $categoria = $_POST['categoria'];
                    $cantidad = $_POST['cantidad'];
                    $codigo_barra = $_POST['codigo_barra'];

                    // Actualizar los datos en la base de datos
                    $sql_update = $conexion->prepare("UPDATE productos SET producto=?, proveedor=?, precio_adq=?, precio_venta=?, fecha_ingreso=?, fecha_caducidad=?, categoria=?, cantidad=?, codigo_barra=? WHERE id_producto=?");
                    $sql_update->bind_param("ssddssssii", $producto, $proveedor, $precio_adq, $precio_venta, $fecha_ingreso, $fecha_caducidad, $categoria, $cantidad, $codigo_barra, $id_producto);
                    
                    if($sql_update->execute()) {
                        echo "<p class='text-success'>Los datos se han actualizado correctamente.</p>";
                        header("Location: gestion_inventario.php");
                    } else {
                        echo "<p class='text-danger'>Error al actualizar los datos.</p>";
                    }
                }
            ?>
                <!-- Formulario de edición de productos -->
                <form method="POST" action="">
                    <input type="hidden" name="id_producto" value="<?= $datos->id_producto ?>">
                    <div class="mb-3">
                        <label for="producto" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control" name="producto" value="<?= $datos->producto ?>">
                    </div>
                    <div class="mb-3">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" name="proveedor" value="<?= $datos->proveedor ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPrecioAdq" class="form-label">Precio de adquisición</label>
                        <input type="number" class="form-control" name="precio_adq" value="<?= $datos->precio_adq ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPrecioVenta" class="form-label">Precio de venta</label>
                        <input type="number" class="form-control" name="precio_venta" value="<?= $datos->precio_venta ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputFechaIngreso" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" name="fecha_ingreso" value="<?= $datos->fecha_ingreso ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputFechaCaducidad" class="form-label">Fecha de caducidad</label>
                        <input type="date" class="form-control" name="fecha_caducidad" value="<?= $datos->fecha_caducidad ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputCategoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" name="categoria" value="<?= $datos->categoria ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputCantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" value="<?= $datos->cantidad ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputCantidad" class="form-label">Codigo de barra</label>
                        <input type="number" class="form-control" name="codigo_barra" value="<?= $datos->codigo_barra ?>">
                    </div>

                    <button type="submit" class="btn btn-primary" name="boton_editar" value="ok">Guardar Cambios</button>
                </form>
            <?php
            } else {
                echo "<p class='text-danger'>No se ha proporcionado un ID de producto válido.</p>";
            }
            ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
