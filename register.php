<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Capturar datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

// Insertar en tabla cliente
$sql_cliente = "INSERT INTO cliente (Nombre, Correo, Telefono) VALUES ('$nombre', '$correo', '$telefono')";
if ($conn->query($sql_cliente) === TRUE) {
    $id_cliente = $conn->insert_id; // Obtener el último ID insertado

    // Insertar en tabla cuenta_cliente
    $sql_cuenta = "INSERT INTO cuenta_cliente (ID_Cliente, Usuario, Contrasena) VALUES ('$id_cliente', '$usuario', '$contrasena')";
    if ($conn->query($sql_cuenta) === TRUE) {
        echo "Cuenta registrada exitosamente. <a href='login.php'>Volver</a>";
    } else {
        echo "Error: " . $sql_cuenta . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_cliente . "<br>" . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Imprenta El Camino</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="register/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"><span>IMPRENTA EL CAMINO</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Nuestra Imprenta</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Cómo Comprar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Registrate</a></li>
                    <li class="nav-item"><a class="nav-link cta-btn" href="#">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="success-container">
        <h1>¡Cuenta registrada exitosamente!</h1>
        <p>Gracias por registrarte en nuestro sistema. Ahora puedes iniciar sesión para disfrutar de nuestros servicios.</p>
        <a href="login.php">Iniciar Sesión</a>
    </div>

    <!-- Enlace a Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>