<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Imprenta El Camino</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Encabezado -->
    <header class="bg-dark text-white p-3">
        <div class="container">
            <h1 class="text-center">Imprenta El Camino</h1>
        </div>
    </header>

    <!-- Menú de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="inicio.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="nuestra_imprenta.php">Nuestra Imprenta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="como_comprar.php">Cómo Comprar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Inicia Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Bienvenido a Imprenta El Camino</h2>
                <p>
                    Somos una imprenta dedicada a ofrecer servicios de serigrafiado y personalización de productos de alta calidad. Explora nuestra tienda para descubrir nuestras ofertas y servicios.
                </p>
                <a href="shop.php" class="btn btn-primary">Ver Tienda</a>
            </div>
            <div class="col-md-6">
                <img src="imagenes/banner_imprenta.jpg" alt="Imprenta El Camino" class="img-fluid">
            </div>
        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Imprenta El Camino. Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
