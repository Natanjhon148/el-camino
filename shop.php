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

// Obtener productos
$sql = "SELECT * FROM producto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Imprenta & Serigrafía "El Camino"</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="tienda/tienda.css">
</head>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.html">IMPRENTA EL CAMINO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="nuestra-imprenta.html">Nuestra Imprenta</a></li>
                        <li class="nav-item"><a class="nav-link active" href="tienda.html">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="como-comprar.html">Cómo Comprar</a></li>
                        <li class="nav-item"><a class="nav-link cta-btn" href="login.php">cerrar sesion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</head>
<body>
<div class="container my-5">
    <h1>Tienda</h1>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo file_exists($row['Imagen']) ? $row['Imagen'] : 'imagenes_productos/imagen_default.jpg'; ?>" 
                             alt="Imagen del producto" class="product-image card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['Nombre']; ?></h5>
                            <p class="card-text">Precio: Bs <?php echo number_format($row['Precio'], 2); ?></p>
                            <p class="card-text">Stock: <?php echo $row['Stock']; ?></p>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">
                                <input type="number" name="cantidad" class="form-control mb-2" min="1" max="<?php echo $row['Stock']; ?>" value="1" required>
                                <button type="submit" class="btn btn-primary w-100">Añadir al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">No hay productos disponibles en la tienda.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
