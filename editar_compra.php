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

$mensaje = ""; // Variable para mostrar el mensaje

// Procesar eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id_producto = $_POST['id_producto'];
    $id_carrito = $_SESSION['id_carrito']; // Suponiendo que el carrito está almacenado en la sesión

    $delete_sql = "DELETE FROM carrito_producto WHERE ID_Producto = ? AND ID_Carrito = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('ii', $id_producto, $id_carrito);
    if ($stmt->execute()) {
        $mensaje = "Producto eliminado exitosamente.";
    } else {
        $mensaje = "Hubo un error al eliminar el producto.";
    }
    $stmt->close();
}

// Consulta para obtener los productos en el carrito
$id_carrito = $_SESSION['id_carrito']; // Asumiendo que el ID del carrito está en la sesión
$sql = "SELECT 
            p.ID_Producto,
            p.Nombre AS Producto,
            cp.Cantidad,
            cp.Precio_Subtotal
        FROM carrito_producto cp
        JOIN producto p ON cp.ID_Producto = p.ID_Producto
        WHERE cp.ID_Carrito = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_carrito);
$stmt->execute();
$result = $stmt->get_result();

// Calcular el subtotal y total
$subtotal = 0;
$total = 0;
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
    $subtotal += $row['Precio_Subtotal'];
    $total = $subtotal; // Aquí se pueden agregar otros cálculos como impuestos
}
?>

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #1d3557;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background: #457b9d;
            color: white;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            cursor: pointer;
        }

        .btn-blue {
            background: #007bff;
        }

        .btn-green {
            background: #28a745;
        }

        .btn-red {
            background: #dc3545;
        }

        .btn-red:hover {
            background: #c82333;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['Producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Cantidad']); ?></td>
                            <td>Bs <?php echo number_format($producto['Precio_Subtotal'], 2); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['ID_Producto']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-red">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">El carrito está vacío.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <p><strong>Subtotal:</strong> Bs <?php echo number_format($subtotal, 2); ?></p>
        <p><strong>Total:</strong> Bs <?php echo number_format($total, 2); ?></p>
        <div class="actions">
            <a href="view_orders.php" class="btn btn-green">volver atras</a>
        </div>
    </div>
</body>
</html>
