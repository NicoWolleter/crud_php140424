<?php
// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once $_SERVER['DOCUMENT_ROOT'] . "/crud_php/modelo/conexion.php";

    // Obtener los datos del formulario
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $contacto_proveedor = $_POST['contacto_proveedor'];
    $info_facturacion = $_POST['info_facturacion'];
    $info_envio = $_POST['info_envio'];
    $categoria_proveedor = $_POST['categoria_proveedor'];
    $fecha_registro = $_POST['fecha_registro'];
    $estado_proveedor = $_POST['estado_proveedor'];

    // Insertar el proveedor en la base de datos
    $sql_insert = "INSERT INTO proveedores (nombre_proveedor, contacto_proveedor, info_facturacion, info_envio, categoria_proveedor, fecha_registro, estado_proveedor) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $nombre_proveedor, $contacto_proveedor, $info_facturacion, $info_envio, $categoria_proveedor, $fecha_registro, $estado_proveedor);

    if ($stmt_insert->execute()) {
        // Proveedor registrado exitosamente
        echo "<p class='text-success'>Proveedor registrado correctamente.</p>";
    } else {
        echo "<p class='text-danger'>Error al registrar el proveedor.</p>";
    }
}
?>
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
        .navbar {
        background-color: #007bff; /* Cambia el color de fondo de la barra de navegación a azul */
        padding: 20px 0; /* Ajusta el relleno vertical (20px) y elimina el relleno horizontal */
        }

        .navbar-nav .nav-link {
        color: black !important; /* Cambia el color del texto de los enlaces */
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
    <h1 class="text-center p-3">GESTION DE PROVEEDORES</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

            <!-- formulario de registro de proveedores -->

                <form method="POST">
                    <h3 class="text-center text-secondary">Registro de proveedores</h3>
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
                        <input type="date" class="form-control" name="fecha_registro">
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
                <table id="tablaProveedores" class="table">
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script> <!-- DataTables -->
    <script>
        $(document).ready(function() {
            $('#tablaProveedores').DataTable({
                "pagingType": "simple_numbers", // Muestra solo los números de paginación
                "pageLength": 5 // Establece la cantidad máxima de elementos por página
            });
        });
    </script>
</body>
</html>
