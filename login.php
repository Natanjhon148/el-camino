<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Imprenta El Camino</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mi-cuenta/mi-cuenta.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.html"><span>IMPRENTA EL CAMINO</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="nuestra-imprenta.html">Nuestra Imprenta</a></li>
                        <li class="nav-item"><a class="nav-link active" href="tienda.html">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="como-comprar.html">Cómo Comprar</a></li>
                        <li class="nav-item"><a class="nav-link cta-btn" href="login.php">Iniciar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="login-container text-center p-4">
            <h1 class="mb-4">Inicio de Sesión</h1>
            <form action="validate_login.php" method="POST" class="text-start">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>
            <p class="mt-3">¿No tienes una cuenta? <a href="registrate.php" class="text-decoration-none">Regístrate aquí</a>.</p>
        </div>
    </main>

     <!-- Footer -->
     <footer class="footer-bg py-4">
        <div class="container text-center">
            <p>&copy; 2024 ImprentaWeb. Todos los derechos reservados.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="text-white">Instagram</a>
                <a href="#" class="text-white">WhatsApp</a>
            </div>
            <p>Escanea el código QR para más información y contacto rápido.</p>
            <img src="Imag/qr.png" class="img-fluid" alt="QR Código" style="max-width: 100px;">
        </div>
    </footer>
</body>
</html>
