<?php
// Verificar si se ha recibido el id_proveedor
if(isset($_GET['id'])) {
    // Incluir el archivo de conexión a la base de datos
    include "modelo/conexion.php";

    // Obtener el id_proveedor de la URL
    $id_proveedor = $_GET['id'];

    // Verificar si se ha enviado el formulario de eliminación
    if(isset($_POST['boton_eliminar']) && $_POST['boton_eliminar'] === "ok") {
        // Eliminar el registro de la base de datos
        $sql_delete = $conexion->prepare("DELETE FROM proveedores WHERE id_proveedor = ?");
        $sql_delete->bind_param("i", $id_proveedor);
        
        if($sql_delete->execute()) {
            // Redirigir al usuario a proveedores.php después de eliminar el proveedor
            header("Location: proveedores.php?mensaje=Proveedor+eliminado");
            exit(); // Es importante salir del script después de redirigir
        } else {
            echo "<p class='text-danger'>Error al eliminar el proveedor.</p>";
        }
    }
} else {
    echo "<p class='text-danger'>No se ha proporcionado un ID de proveedor válido.</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Proveedor</title>
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
        <h1 class="text-center p-3">Eliminar Proveedor</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Formulario de eliminación de proveedor -->
                <form method="POST" action="">
                    <p>¿Estás seguro de que quieres eliminar este proveedor?</p>
                    <input type="hidden" name="id_proveedor" value="<?= $id_proveedor ?>">
                    <button type="submit" class="btn btn-danger" name="boton_eliminar" value="ok">Eliminar Proveedor</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
