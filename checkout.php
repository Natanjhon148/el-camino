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

// Validar que el carrito y total existen en la sesión
if (!isset($_SESSION['id_carrito']) || !isset($_SESSION['total'])) {
    $_SESSION['total'] = 150; // Ejemplo de total para pruebas (reemplaza con el valor real)
    $_SESSION['id_carrito'] = 1; // ID de carrito para pruebas (reemplaza con el valor real)
}

$id_carrito = $_SESSION['id_carrito'];
$total = $_SESSION['total'];

// Incluir biblioteca QR
require_once 'phpqrcode/qrlib.php';

// Verificar que exista la carpeta para guardar el QR
if (!is_dir('qrcodes')) {
    mkdir('qrcodes', 0777, true);
}

// Generar QR
$qr_data = "Total a pagar: Bs $total. ID del carrito: $id_carrito.";
$qr_file = "qrcodes/pago_$id_carrito.png";
QRcode::png($qr_data, $qr_file);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pago</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5 text-center">
        <h1>Confirmación de Pago</h1>
        <p>El total de tu carrito es:</p>
        <h2><strong>Bs <?php echo number_format($total, 2); ?></strong></h2>
        <p>Escanea este código QR para completar el pago:</p>
        <img src="<?php echo $qr_file; ?>" alt="Código QR de Pago" style="max-width: 200px;">
        <div class="mt-4">
            <p>Para más información o asistencia, contáctanos:</p>
            <a href="https://wa.me/1234567890" class="btn btn-success">WhatsApp</a>
            <a href="https://facebook.com" class="btn btn-primary">Facebook</a>
            <a href="https://goo.gl/maps/your-location" class="btn btn-info">Ubicación</a>
        </div>
        <a href="shop.php" class="btn btn-secondary mt-3">Volver a la Tienda</a>
    </div>
</body>
</html>
