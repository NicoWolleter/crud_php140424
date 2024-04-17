<?php
// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once $_SERVER['DOCUMENT_ROOT'] . "/crud_php/modelo/conexion.php";

    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_usuario = $_POST['correo_usuario'];
    $rol_usuario = $_POST['rol_usuario'];
    $password_usuario = $_POST['password_usuario'];
    $fecha_registro = date("Y-m-d H:i:s");

    // Verificar si el nombre de usuario y el correo ya existen en la base de datos
    $sql_check = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR correo_usuario = ?";
    $stmt = $conexion->prepare($sql_check);
    $stmt->bind_param("ss", $nombre_usuario, $correo_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p class='text-danger'>El nombre de usuario o correo electrónico ya están registrados.</p>";
    } else {
        // Verificar la fortaleza de la contraseña
        $uppercase = preg_match('@[A-Z]@', $password_usuario);
        $lowercase = preg_match('@[a-z]@', $password_usuario);
        $number    = preg_match('@[0-9]@', $password_usuario);
        $specialChars = preg_match('@[^\w]@', $password_usuario);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password_usuario) < 8) {
            echo "<p class='text-danger'>La contraseña debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas, números y caracteres especiales.</p>";
        } else {
            // Insertar el usuario en la base de datos
            $sql_insert = "INSERT INTO usuarios (nombre_usuario, correo_usuario, rol_usuario, password_usuario, fecha_registro) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conexion->prepare($sql_insert);
            $stmt_insert->bind_param("sssss", $nombre_usuario, $correo_usuario, $rol_usuario, $password_usuario, $fecha_registro);

            if ($stmt_insert->execute()) {
                // Usuario registrado exitosamente, redirigir a login.php
                header("Location: login.php");
                exit();
            } else {
                echo "<p class='text-danger'>Error al registrar el usuario.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
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
        <h1 class="text-center p-3">Registro de Usuarios</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="nombre_usuario">
                    </div>
                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo_usuario">
                    </div>
                    <div class="mb-3">
                        <label for="rol_usuario" class="form-label">Rol de Usuario</label>
                        <select class="form-select" name="rol_usuario">
                            <option value="administrador">Administrador</option>
                            <option value="operario">Operario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password_usuario" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password_usuario">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
