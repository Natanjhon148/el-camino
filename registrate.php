<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Imprenta El Camino</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Regístrate/Regístrate.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                        <li class="nav-item"><a class="nav-link active" href="index.html">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="nuestra-imprenta.html">Nuestra Imprenta</a></li>
                        <li class="nav-item"><a class="nav-link" href="tienda.html">Tienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="como-comprar.html">Cómo Comprar</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Registrate</a></li>
                        <li class="nav-item"><a class="nav-link cta-btn" href="cotiza.html">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-5 shadow-lg" style="width: 400px; border-radius: 20px; background-color: #fefefe;">
        <h2 class="text-center mb-4" style="color: #1d3557; font-weight: bold;">Regístrate</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label" style="font-weight: 600;">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Tu nombre" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label" style="font-weight: 600;">Correo:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="correo" name="correo" class="form-control" placeholder="Tu correo" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label" style="font-weight: 600;">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Tu teléfono" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label" style="font-weight: 600;">Usuario:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label" style="font-weight: 600;">Contraseña:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3" style="background: linear-gradient(135deg, #e63946, #ffba08); border: none; font-weight: bold;">Registrar</button>
        </form>
    </div>
</div>



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
 
    <!-- Bootstrap JS -->
</body>
</html>

</body>
</html>
