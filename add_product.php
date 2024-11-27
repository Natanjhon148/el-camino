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

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Validar y manejar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen']['name'];
        $directorio_imagenes = "imagenes_productos/";
        $ruta_imagen = $directorio_imagenes . basename($imagen);

        // Verifica que la carpeta exista, si no la crea
        if (!is_dir($directorio_imagenes)) {
            mkdir($directorio_imagenes, 0777, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO producto (Nombre, Precio, Stock, Imagen) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdis", $nombre, $precio, $stock, $ruta_imagen);

            if ($stmt->execute()) {
                $mensaje = "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al agregar el producto: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al subir la imagen. Inténtalo de nuevo.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Por favor, selecciona una imagen válida.</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #d3e4fd, #a8c0f0);
            min-height: 100vh;
            margin: 0;
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
            font-size: 2rem;
            color: #1d3557;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            border-radius: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            margin-top: 10px;
            border-radius: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #457b9d;
        }

        .form-control {
            border-radius: 10px;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Agregar Producto</h1>
        <?php if (!empty($mensaje)) echo $mensaje; ?>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
            <a href="dashboard_empleado.php" class="btn btn-secondary w-100 mt-3">Volver al Dashboard</a>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
