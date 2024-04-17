<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD CAFETERIA</title>
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
    <h1 class="text-center p-3">GESTION DE PROVEEDORES</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

            <!-- formulario de registro de productos -->

                <form method="POST">
                    <h3 class="text-center text-secondary">Registro de proveerdores</h3>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nombre del proveedor</label>
                        <input type="text" class="form-control" name="nombre_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Contacto</label>
                        <input type="text" class="form-control" name="contacto_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Información de facturación</label>
                        <input type="text" class="form-control" name="info_facturacion">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Información de envío</label>
                        <input type="text" class="form-control" name="info_envio">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Categoria de proveedor</label>
                        <input type="text" class="form-control" name="categoria_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Fecha de registro</label>
                        <input type="text" class="form-control" name="fecha_registro">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Estado de proveedor</label>
                        <input type="text" class="form-control" name="estado_proveedor">
                    </div>
                    <button type="submit" class="btn btn-primary" name="boton_registro" value="ok">Ingresar</button>
                </form>
            </div>

            <!-- tabla de visualizacion de productos -->
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr class="bg-info">
                            <th scope="col">id_proveedor</th>
                            <th scope="col">Nombre del proveedor</th>
                            <th scope="col">Contacto</th>
                            <th scope="col">información de facturación</th>
                            <th scope="col">información de envio</th>
                            <th scope="col">categoria de proveedor</th>
                            <th scope="col">fecha de registro</th>
                            <th scope="col">estado de proveedor</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "modelo/conexion.php";
                        include "controlador/registro_productos.php";
                        $sql = $conexion->query("SELECT * FROM proveedores");
                        while ($datos = $sql->fetch_object()) { ?>
                            <tr>
                                    <td><?= $datos->id_proveedor ?></td>
                                    <td><?= $datos->nombre_proveedor ?></td>
                                    <td><?= $datos->contacto_proveedor ?></td>
                                    <td><?= $datos->info_facturacion ?></td>
                                    <td><?= $datos->info_envio ?></td>
                                    <td><?= $datos->categoria_proveedor ?></td>
                                    <td><?= $datos->fecha_registro ?></td>
                                    <td><?= $datos->estado_proveedor ?></td>
                                    <td>
                                    <a href="editar_proveedor.php?id=<?= $datos->id_proveedor ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-user-pen"></i></a>
                                    <a href="eliminar_proveedor.php?id=<?= $datos->id_proveedor ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
