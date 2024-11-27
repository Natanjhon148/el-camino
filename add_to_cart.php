<?php
session_start();

// Verificar que el carrito está activo
if (!isset($_SESSION['id_carrito'])) {
    die("No hay un carrito activo. <a href='shop.php'>Volver a la tienda</a>");
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Capturar datos del formulario
$id_producto = $_POST['id_producto'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;

if (!$id_producto || !$cantidad || $cantidad <= 0) {
    die("Datos incompletos o cantidad inválida. <a href='shop.php'>Volver a la tienda</a>");
}

// Verificar que el producto existe y tiene suficiente stock
$sql = "SELECT Precio, Stock FROM producto WHERE ID_Producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    die("El producto no existe. <a href='shop.php'>Volver a la tienda</a>");
}

if ($producto['Stock'] < $cantidad) {
    die("No hay suficiente stock. <a href='shop.php'>Volver a la tienda</a>");
}

$id_carrito = $_SESSION['id_carrito'];
$subtotal = $producto['Precio'] * $cantidad;

// Verificar si el producto ya está en el carrito
$sql_check = "SELECT Cantidad, Precio_Subtotal FROM carrito_producto WHERE ID_Carrito = ? AND ID_Producto = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_carrito, $id_producto);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Actualizar cantidad y subtotal si el producto ya está en el carrito
    $producto_carrito = $result_check->fetch_assoc();
    $nueva_cantidad = $producto_carrito['Cantidad'] + $cantidad;
    $nuevo_subtotal = $producto_carrito['Precio_Subtotal'] + $subtotal;

    $sql_update = "UPDATE carrito_producto 
                   SET Cantidad = ?, Precio_Subtotal = ? 
                   WHERE ID_Carrito = ? AND ID_Producto = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("idii", $nueva_cantidad, $nuevo_subtotal, $id_carrito, $id_producto);
    $stmt_update->execute();
} else {
    // Insertar producto en el carrito si no está ya presente
    $sql_insert = "INSERT INTO carrito_producto (ID_Carrito, ID_Producto, Cantidad, Precio_Subtotal) 
                   VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiid", $id_carrito, $id_producto, $cantidad, $subtotal);
    $stmt_insert->execute();
}

// Actualizar los totales del carrito
$sql_totales = "UPDATE carrito 
                SET Subtotal = (SELECT COALESCE(SUM(Precio_Subtotal), 0) FROM carrito_producto WHERE ID_Carrito = ?),
                    Total = Subtotal - Descuento
                WHERE ID_Carrito = ?";
$stmt_totales = $conn->prepare($sql_totales);
$stmt_totales->bind_param("ii", $id_carrito, $id_carrito);
$stmt_totales->execute();

header("Location: cart.php"); // Redirigir al carrito
exit;
?>
