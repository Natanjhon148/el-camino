<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si hay un carrito activo
if (!isset($_SESSION['id_carrito'])) {
    die("No hay un carrito activo. <a href='shop.php'>Volver a la tienda</a>");
}

$id_carrito = $_SESSION['id_carrito'];

// Manejar la eliminación de productos
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];
    
    // Eliminar el producto del carrito
    $sql_delete = "DELETE FROM carrito_producto WHERE ID_Carrito = ? AND ID_Producto = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $id_carrito, $id_producto);
    $stmt_delete->execute();
}

// Obtener productos en el carrito
$sql = "SELECT p.ID_Producto, p.Nombre, cp.Cantidad, (cp.Cantidad * p.Precio) AS Precio_Subtotal 
        FROM carrito_producto cp
        JOIN producto p ON cp.ID_Producto = p.ID_Producto
        WHERE cp.ID_Carrito = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_carrito);
$stmt->execute();
$result = $stmt->get_result();
$productos = $result->fetch_all(MYSQLI_ASSOC);

// Calcular totales
$subtotal = 0;
$total = 0;

foreach ($productos as $producto) {
    $subtotal += $producto['Precio_Subtotal'];
}
$total = $subtotal;

// Actualizar los totales en la base de datos
$sql_update_totales = "UPDATE carrito SET Subtotal = ?, Total = ? WHERE ID_Carrito = ?";
$stmt_update_totales = $conn->prepare($sql_update_totales);
$stmt_update_totales->bind_param("dii", $subtotal, $total, $id_carrito);
$stmt_update_totales->execute();

// Guardar el total en la sesión
$_SESSION['total'] = $total;

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>Carrito de Compras</h1>
        <?php if (!empty($productos)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['Nombre']); ?></td>
                            <td><?php echo $producto['Cantidad']; ?></td>
                            <td>Bs <?php echo number_format($producto['Precio_Subtotal'], 2); ?></td>
                            <td>
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['ID_Producto']; ?>">
                                    <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3">
                <p><strong>Subtotal:</strong> Bs <?php echo number_format($subtotal, 2); ?></p>
                <p><strong>Total:</strong> Bs <?php echo number_format($total, 2); ?></p>
                <div class="d-flex gap-2">
                    <form action="payment.php" method="POST">
                        <button type="submit" class="btn btn-primary">Proceder al Pago</button>
                    </form>
                    <a href="shop.php" class="btn btn-success">Seguir Comprando</a>
                </div>
            </div>
        <?php else: ?>
            <p>Tu carrito está vacío. <a href="shop.php">Volver a la tienda</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
