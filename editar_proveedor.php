<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
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
        <h1 class="text-center p-3">Editar Proveedor</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">

            <?php
            // Verificar si se ha recibido el id_proveedor
            if(isset($_GET['id'])) {
                // Incluir el archivo de conexión a la base de datos
                include "modelo/conexion.php";

                // Obtener el id_proveedor de la URL
                $id_proveedor = $_GET['id'];

                // Obtener los datos del proveedor de la base de datos
                $sql = $conexion->query("SELECT * FROM proveedores WHERE id_proveedor = $id_proveedor");
                $datos = $sql->fetch_object();

                // Verificar si se ha enviado el formulario de edición
                if(isset($_POST['boton_editar']) && $_POST['boton_editar'] === "ok") {
                    // Obtener los datos del formulario
                    $nombre_proveedor = $_POST['nombre_proveedor'];
                    $contacto_proveedor = $_POST['contacto_proveedor'];
                    $info_facturacion = $_POST['info_facturacion'];
                    $info_envio = $_POST['info_envio'];
                    $categoria_proveedor = $_POST['categoria_proveedor'];
                    $fecha_registro = $_POST['fecha_registro'];
                    $estado_proveedor = $_POST['estado_proveedor'];

                    // Actualizar los datos en la base de datos
                    $sql_update = $conexion->prepare("UPDATE proveedores SET nombre_proveedor=?, contacto_proveedor=?, info_facturacion=?, info_envio=?, categoria_proveedor=?, fecha_registro=?, estado_proveedor=? WHERE id_proveedor=?");
                    $sql_update->bind_param("sssssssi", $nombre_proveedor, $contacto_proveedor, $info_facturacion, $info_envio, $categoria_proveedor, $fecha_registro, $estado_proveedor, $id_proveedor);
                    
                    if($sql_update->execute()) {
                        echo "<p class='text-success'>Los datos se han actualizado correctamente.</p>";
                        header("Location: proveedores.php");
                    } else {
                        echo "<p class='text-danger'>Error al actualizar los datos.</p>";
                    }
                }
            ?>
                <!-- Formulario de edición de proveedores -->
                <form method="POST" action="">
                    <input type="hidden" name="id_proveedor" value="<?= $datos->id_proveedor ?>">
                    <div class="mb-3">
                        <label for="nombre_proveedor" class="form-label">Nombre del proveedor</label>
                        <input type="text" class="form-control" name="nombre_proveedor" value="<?= $datos->nombre_proveedor ?>">
                    </div>
                    <div class="mb-3">
                        <label for="contacto_proveedor" class="form-label">Contacto</label>
                        <input type="text" class="form-control" name="contacto_proveedor" value="<?= $datos->contacto_proveedor ?>">
                    </div>
                    <div class="mb-3">
                        <label for="info_facturacion" class="form-label">Información de facturación</label>
                        <input type="text" class="form-control" name="info_facturacion" value="<?= $datos->info_facturacion ?>">
                    </div>
                    <div class="mb-3">
                        <label for="info_envio" class="form-label">Información de envío</label>
                        <input type="text" class="form-control" name="info_envio" value="<?= $datos->info_envio ?>">
                    </div>
                    <div class="mb-3">
                        <label for="categoria_proveedor" class="form-label">Categoría de proveedor</label>
                        <input type="text" class="form-control" name="categoria_proveedor" value="<?= $datos->categoria_proveedor ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de registro</label>
                        <input type="date" class="form-control" name="fecha_registro" value="<?= $datos->fecha_registro ?>">
                    </div>
                    <div class="mb-3">
                        <label for="estado_proveedor" class="form-label">Estado de proveedor</label>
                        <input type="text" class="form-control" name="estado_proveedor" value="<?= $datos->estado_proveedor ?>">
                    </div>

                    <button type="submit" class="btn btn-primary" name="boton_editar" value="ok">Guardar Cambios</button>
                </form>
            <?php
            } else {
                echo "<p class='text-danger'>No se ha proporcionado un ID de proveedor válido.</p>";
            }
            ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
