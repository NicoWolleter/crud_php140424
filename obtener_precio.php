<?php
// Incluir la conexión a la base de datos
include 'modelo/conexion.php';

// Obtener el código de barras del producto desde la URL
$codigo_barra = $_GET['codigo_barra'];

// Consultar el precio del producto en la base de datos
$sql_precio = "SELECT precio_venta FROM productos WHERE codigo_barra = ?";
$stmt_precio = $conexion->prepare($sql_precio);
$stmt_precio->bind_param("s", $codigo_barra);
$stmt_precio->execute();
$result_precio = $stmt_precio->get_result();

if ($result_precio->num_rows == 1) {
    $row_precio = $result_precio->fetch_assoc();
    $precio = $row_precio['precio_venta'];
    echo $precio;
} else {
    echo '0'; // Devolver 0 si el producto no existe o no se encontró el precio
}
?>