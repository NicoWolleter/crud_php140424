<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD CAFETERIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/52820557f8.js" crossorigin="anonymous"></script>
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

        .container-fluid {
            background-color: rgba(255, 255, 255, 0.9); /* Agrega un fondo semi-transparente a los contenidos para mejorar la legibilidad */
            padding: 20px; /* Añade relleno para separar los contenidos del fondo */
        }
    </style>
</head>
<body>
    <h1 class="text-center p-3">INVENTARIO DE CAFETERIA</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

            <!-- formulario de registro de productos -->

                <form method="POST">
                    <h3 class="text-center text-secondary">Registro de productos</h3>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control" name="producto">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" name="proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Precio de adquisición</label>
                        <input type="number" class="form-control" name="precio_adq">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Precio de venta</label>
                        <input type="number" class="form-control" name="precio_venta">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" name="fecha_ingreso">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Fecha de caducidad</label>
                        <input type="date" class="form-control" name="fecha_caducidad">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Categoria</label>
                        <input type="text" class="form-control" name="categoria">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Codigo de barra</label>
                        <input type="number" class="form-control" name="codigo_barra">
                    </div>
                    <button type="submit" class="btn btn-primary" name="boton_registro" value="ok">Ingresar</button>
                </form>
            </div>

                <!-- tabla de visualizacion de productos -->
    <div class="col-md-8">
        <table class="table" id="tablaProductos"> <!-- Añade el ID "tablaProductos" a la tabla -->
            <thead>
                <tr class="bg-info">
                    <th scope="col">id_producto</th>
                    <th scope="col">producto</th>
                    <th scope="col">proveedor</th>
                    <th scope="col">precio de adquisición</th>
                    <th scope="col">precio de venta</th>
                    <th scope="col">fecha de adquisición</th>
                    <th scope="col">fecha de caducidad</th>
                    <th scope="col">categoria</th>
                    <th scope="col">cantidad</th>
                    <th scope="col">codigo_barra</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "modelo/conexion.php";
                include "controlador/registro_productos.php";
                $sql = $conexion->query("SELECT * FROM productos");
                while ($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->id_producto ?></td>
                        <td><?= $datos->producto ?></td>
                        <td><?= $datos->proveedor ?></td>
                        <td><?= $datos->precio_adq ?></td>
                        <td><?= $datos->precio_venta ?></td>
                        <td><?= $datos->fecha_ingreso ?></td>
                        <td><?= $datos->fecha_caducidad ?></td>
                        <td><?= $datos->categoria ?></td>
                        <td><?= $datos->cantidad ?></td>
                        <td><?= $datos->codigo_barra ?></td>
                        <td>
                            <a href="editar_productos.php?id=<?= $datos->id_producto ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-user-pen"></i></a>
                            <a href="eliminar_productos.php?id=<?= $datos->id_producto ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Agrega jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agrega DataTables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializa la tabla con DataTables
            $('#tablaProductos').DataTable({
                "pagingType": "simple_numbers", // Muestra solo los números de paginación
                "pageLength": 5 // Establece la cantidad máxima de elementos por página
            });
        });
    </script>
</body>
</html>