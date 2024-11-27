<?php
session_start();
if (!isset($_SESSION['usuario_empleado'])) {
    header("Location: login_empleado.php");
    exit;
}
$nombre_empleado = $_SESSION['usuario_empleado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .dashboard-container h1 {
            font-size: 2.5rem;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        .dashboard-container p {
            font-size: 1.2rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-dashboard {
            width: 100%;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #003f7f);
        }
        footer {
            text-align: center;
            margin-top: 50px;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_empleado); ?></h1>
        <p>Selecciona una opción para continuar:</p>
        <div class="d-grid gap-3">
            <a href="add_product.php" class="btn btn-primary btn-dashboard">Agregar Producto</a>
            <a href="delete_product_empleado.php" class="btn btn-primary btn-dashboard">Eliminar Producto</a>
            <a href="view_orders.php" class="btn btn-primary btn-dashboard">Ver Compras de Clientes</a>
            <a href="manage_providers.php" class="btn btn-primary btn-dashboard">Gestionar Proveedores</a>
            <a href="logout.php" class="btn btn-danger btn-dashboard">Cerrar Sesión</a>
        </div>
    </div>
    <footer>
        © 2024 Mi Empresa - Todos los derechos reservados.
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
