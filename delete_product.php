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
$dbname = "el_camino"; // Nombre correcto de la base de datos

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";

// Manejo de eliminación de productos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);

    // Consulta para eliminar el producto
    $sql_delete = "DELETE FROM producto WHERE ID_Producto = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success'>Producto eliminado exitosamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al eliminar el producto: " . $conn->error . "</div>";
    }

    $stmt->close();
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
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
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
            color: #495057;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #bd2130;
        }
        .btn-primary:hover {
            background-color: #b21f2d;
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
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['ID_Producto']; ?>">
                            <?php echo htmlspecialchars($row['Nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Eliminar Producto</button>
            <a href="dashboard_empleado.php" class="btn btn-secondary w-100 mt-3">Volver al Dashboard</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
