<?php
$conexion = new mysqli("localhost", "root", "", "el_camino");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_id'])) {
        $stmt = $conexion->prepare("DELETE FROM proveedores WHERE id = ?");
        $stmt->bind_param("i", $_POST['eliminar_id']);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Proveedor eliminado exitosamente.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO proveedores (nombre, contacto, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['nombre'], $_POST['contacto'], $_POST['telefono']);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Proveedor agregado exitosamente.";
    }
}

$proveedores = $conexion->query("SELECT * FROM proveedores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Variables */
:root {
    --primary-color: #457b9d;
    --secondary-color: #1d3557;
    --accent-color: #e63946;
    --light-color: #f1faee;
    --text-color: #333;
    --border-radius: 8px;
    --transition-speed: 0.3s;
}

/* Global Styles */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: var(--light-color);
    color: var(--text-color);
}

h1, h2 {
    color: var(--secondary-color);
}

a {
    text-decoration: none;
    color: inherit;
}

button {
    border: none;
    cursor: pointer;
}

/* Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--primary-color);
    padding: 15px;
    color: var(--light-color);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.navbar-brand span {
    font-size: 1.5rem;
    font-weight: bold;
}

.navbar .dashboard-button {
    background: var(--accent-color);
    color: var(--light-color);
    padding: 10px 15px;
    border-radius: var(--border-radius);
    font-size: 0.9rem;
    transition: background var(--transition-speed);
}

.navbar .dashboard-button:hover {
    background: var(--secondary-color);
}

/* Header */
.header {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: var(--light-color);
}

.header h1 {
    margin: 0;
    font-size: 2rem;
}

/* Main Container */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 0 15px;
    display: grid;
    grid-gap: 20px;
}

/* Form Section */
.form-section {
    background: white;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.form-section h2 {
    margin-bottom: 20px;
}

.form {
    display: grid;
    gap: 10px;
}

.form input, .form button {
    padding: 10px;
    border: 1px solid var(--primary-color);
    border-radius: var(--border-radius);
}

.form button {
    background: var(--primary-color);
    color: var(--light-color);
    font-weight: bold;
    transition: background var(--transition-speed);
}

.form button:hover {
    background: var(--accent-color);
}

/* Table Section */
.table-section {
    background: white;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.table-section h2 {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

thead {
    background: var(--primary-color);
    color: var(--light-color);
}

th, td {
    padding: 10px;
    border: 1px solid var(--primary-color);
}

tbody tr:nth-child(even) {
    background: var(--light-color);
}

.delete-button {
    background: var(--accent-color);
    color: white;
    padding: 5px 10px;
    border-radius: var(--border-radius);
    font-size: 0.8rem;
    cursor: pointer;
    transition: background var(--transition-speed);
}

.delete-button:hover {
    background: var(--primary-color);
}

/* Alert */
.alert {
    padding: 15px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar, .form-section, .table-section {
        padding: 10px;
    }

    .form {
        grid-template-columns: 1fr;
    }

    table {
        font-size: 0.9rem;
    }
}

/* Footer */
.footer {
    text-align: center;
    padding: 15px;
    background: var(--secondary-color);
    color: var(--light-color);
    font-size: 0.9rem;
}

</style>    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', (e) => {
                    if (!confirm("¿Estás seguro de eliminar este proveedor?")) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <span>El Camino - Proveedores</span>
        </div>
        <a href="dashboard_empleado.php" class="dashboard-button"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a>
    </nav>
    <header class="header">
        <h1>Gestión de Proveedores</h1>
    </header>
    <main class="container">
        <?php if (isset($mensaje)): ?>
            <div class="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <section class="form-section">
            <h2>Agregar Proveedor</h2>
            <form method="POST" class="form">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <label>Contacto:</label>
                <input type="text" name="contacto" required>
                <label>Teléfono:</label>
                <input type="text" name="telefono" required>
                <button type="submit">Agregar</button>
            </form>
        </section>
        <section class="table-section">
            <h2>Lista de Proveedores</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $proveedores->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['contacto']; ?></td>
                        <td><?php echo $fila['telefono']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="eliminar_id" value="<?php echo $fila['id']; ?>">
                                <button type="submit" class="delete-button">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 El Camino - Todos los derechos reservados.</p>
    </footer>
</body>
</html>
