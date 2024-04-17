<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ya inició sesión, redirigirlo si es así
if (isset($_SESSION['correo_usuario'])) {
    header("Location: index.php");
    exit();
}

// Procesar el formulario de inicio de sesión cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once $_SERVER['DOCUMENT_ROOT'] . "/crud_php/modelo/conexion.php";

    // Obtener los datos del formulario
    $correo_usuario = $_POST['correo_usuario'];
    $password_usuario = $_POST['password_usuario'];

    // Consultar la base de datos para obtener la contraseña del usuario
    $sql_check = "SELECT correo_usuario, password_usuario FROM usuarios WHERE correo_usuario = ?";
    $stmt = $conexion->prepare($sql_check);
    $stmt->bind_param("s", $correo_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Vincular las variables de resultado
        $stmt->bind_result($correo_usuario_result, $password_hash);
        $stmt->fetch();
        // Mostrar mensajes de depuración
        echo "Correo encontrado en la base de datos: $correo_usuario_result<br>";
        echo "Contraseña hash almacenada: $password_hash<br>";
        // Verificar la contraseña
        if (password_verify($password_usuario, $password_hash)) {
            // Contraseña correcta, iniciar sesión y redirigir al usuario
            $_SESSION['correo_usuario'] = $correo_usuario;
            header("Location: index.php");
            exit();
        } else {
            // Contraseña incorrecta
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } else {
        // Usuario no encontrado
        $error_message = "Usuario o contraseña incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
        <h1 class="text-center p-3">Iniciar Sesión</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo_usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password_usuario" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password_usuario">
                    </div>
                    <?php if (isset($error_message)): ?>
                        <p class="text-danger"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>