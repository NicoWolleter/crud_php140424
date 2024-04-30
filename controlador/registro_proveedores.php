<?php
// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once $_SERVER['DOCUMENT_ROOT'] . "/modelo/conexion.php";

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
    <title>Registro de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/52820557f8.js" crossorigin="anonymous"></script>
    <style>
        /* Establece la imagen de fondo */
        body {
            background-image: url('../modelo/cafeteria.jpg'); /* Ruta de la imagen */
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
        <h1 class="text-center p-3">Registro de Proveedores</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="nombre_proveedor" class="form-label">Nombre del Proveedor</label>
                        <input type="text" class="form-control" name="nombre_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="contacto_proveedor" class="form-label">Contacto del Proveedor</label>
                        <input type="text" class="form-control" name="contacto_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="info_facturacion" class="form-label">Información de Facturación</label>
                        <input type="text" class="form-control" name="info_facturacion">
                    </div>
                    <div class="mb-3">
                        <label for="info_envio" class="form-label">Información de Envío</label>
                        <input type="text" class="form-control" name="info_envio">
                    </div>
                    <div class="mb-3">
                        <label for="categoria_proveedor" class="form-label">Categoría del Proveedor</label>
                        <input type="text" class="form-control" name="categoria_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                        <input type="date" class="form-control" name="fecha_registro">
                    </div>
                    <div class="mb-3">
                        <label for="estado_proveedor" class="form-label">Estado del Proveedor</label>
                        <input type="text" class="form-control" name="estado_proveedor">
                    </div>
                    <button type="submit" class="btn btn-primary" name="boton_registro" value="ok">Registrar Proveedor</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
