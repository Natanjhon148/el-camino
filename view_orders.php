<?php
session_start();

// Verifica si el empleado ha iniciado sesión
if (!isset($_SESSION['usuario_empleado'])) {
    header("Location: login_empleado.php");
    exit;
}

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id_producto = $_POST['id_producto'];
    $id_carrito = $_POST['id_carrito'];
    
    $delete_sql = "DELETE FROM carrito_producto WHERE ID_Producto = ? AND ID_Carrito = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('ii', $id_producto, $id_carrito);
    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "El producto fue eliminado exitosamente.";
    } else {
        $_SESSION['mensaje_exito'] = "Hubo un error al eliminar el producto.";
    }
    $stmt->close();
    header("Location: view_orders.php");
    exit;
}

// Consulta SQL para obtener los datos necesarios
$sql = "SELECT 
            cp.ID_Producto,
            ca.ID_Carrito,
            c.Nombre AS Cliente, 
            c.Telefono AS Telefono, 
            p.Nombre AS Producto, 
            cp.Cantidad, 
            cp.Precio_Subtotal 
        FROM carrito_producto cp
        JOIN carrito ca ON cp.ID_Carrito = ca.ID_Carrito
        JOIN cliente c ON ca.ID_Cliente = c.ID_Cliente
        JOIN producto p ON cp.ID_Producto = p.ID_Producto";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras de Clientes</title>
    <style>
        /* General */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            color: #1d3557;
            margin: 20px 0;
        }

        /* Tabla responsive */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table thead tr {
            background: #457b9d;
            color: #fff;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background: #f1f1f1;
        }

        table tbody tr:hover {
            background: #e0f7fa;
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }

        table th {
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            font-size: 0.9rem;
        }

        /* Botón */
        a, form button {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #1d3557;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            margin: 5px auto;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        a:hover, form button:hover {
            background: #457b9d;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsividad */
        @media (max-width: 768px) {
            table th, table td {
                font-size: 0.8rem;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <h1>Compras de Clientes</h1>

    <!-- Mostrar mensaje de éxito -->
    <?php
    if (isset($_SESSION['mensaje_exito'])) {
        echo "<p style='text-align: center; color: green; font-weight: bold;'>" . htmlspecialchars($_SESSION['mensaje_exito']) . "</p>";
        unset($_SESSION['mensaje_exito']); // Eliminar el mensaje después de mostrarlo
    }
    ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Cliente']); ?></td>
                        <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['Producto']); ?></td>
                        <td><?php echo $row['Cantidad']; ?></td>
                        <td>Bs <?php echo number_format($row['Precio_Subtotal'], 2); ?></td>
                        <td>
                            <!-- Formulario para eliminar -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">
                                <input type="hidden" name="id_carrito" value="<?php echo $row['ID_Carrito']; ?>">
                                <button type="submit" name="eliminar">Eliminar</button>
                            </form>
                            <!-- Enlace para editar -->
                            <a href="editar_compra.php?id_producto=<?php echo $row['ID_Producto']; ?>&id_carrito=<?php echo $row['ID_Carrito']; ?>">Detalles</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 1.2rem;">No hay compras registradas.</p>
    <?php endif; ?>
    <div style="text-align: center; margin: 20px;">
        <a href="dashboard_empleado.php">Volver al Dashboard</a>
        <a href="descargar_pdf_compras.php">Descargar PDF</a>
    </div>
</body>
</html>
