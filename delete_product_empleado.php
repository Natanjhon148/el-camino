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
$password = ""; // Sin contraseña por defecto en XAMPP
$dbname = "el_camino"; // Nombre correcto de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";

// Manejar la eliminación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']); // Asegura que el valor sea un entero

    // Verifica si el ID es válido
    $sql_verify = "SELECT COUNT(*) AS count FROM producto WHERE ID_Producto = ?";
    $stmt_verify = $conn->prepare($sql_verify);
    $stmt_verify->bind_param("i", $id_producto);
    $stmt_verify->execute();
    $result_verify = $stmt_verify->get_result();
    $row_verify = $result_verify->fetch_assoc();

    if ($row_verify['count'] > 0) {
        // Eliminar el producto de la base de datos
        $sql_delete = "DELETE FROM producto WHERE ID_Producto = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete) {
            $stmt_delete->bind_param("i", $id_producto);
            if ($stmt_delete->execute()) {
                $mensaje = "<div class='alert alert-success'>Producto eliminado exitosamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al eliminar el producto: " . $stmt_delete->error . "</div>";
            }
            $stmt_delete->close();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al preparar la consulta: " . $conn->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>El producto no existe.</div>";
    }
    $stmt_verify->close();
}

// Obtener la lista de productos
$sql = "SELECT ID_Producto, Nombre FROM producto";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #721c24;
        }
        .btn-primary {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-primary:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Eliminar Producto</h1>
        <?php if (!empty($mensaje)) echo $mensaje; ?>
        <form action="delete_product.php" method="POST">
            <div class="mb-3">
                <label for="id_producto" class="form-label">Selecciona un Producto:</label>
                <select id="id_producto" name="id_producto" class="form-select" required>
                    <option value="" disabled selected>Elige un producto</option>
                    <?php if ($result): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?php echo $row['ID_Producto']; ?>">
                                <?php echo htmlspecialchars($row['Nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Eliminar Producto</button>
            <a href="dashboard_empleado.php" class="btn btn-secondary w-100 mt-3">Volver al Dashboard</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
