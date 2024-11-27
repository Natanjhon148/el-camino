<?php
session_start();

// Verificar si hay un total en la sesión
if (!isset($_SESSION['total'])) {
    die("No se puede procesar el pago. <a href='cart.php'>Volver al carrito</a>");
}

$total = $_SESSION['total'];

// Incluir la biblioteca de QR Code
require_once 'phpqrcode/qrlib.php';

// Verificar que exista la carpeta para guardar el QR
if (!is_dir('qrcodes')) {
    mkdir('qrcodes', 0777, true);
}

// Generar el código QR con los datos del carrito
$qr_data = "Total a pagar: Bs $total.";
$qr_file = "qrcodes/pago.png";
QRcode::png($qr_data, $qr_file);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pago</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .btn-contact {
            width: 150px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4">Confirmación de Pago</h1>
        <p>El total de tu carrito es:</p>
        <h2><strong>Bs <?php echo number_format($total, 2); ?></strong></h2>
        <p class="mt-3">Escanea este código QR para completar el pago:</p>
        <img src="<?php echo $qr_file; ?>" alt="Código QR de Pago" style="max-width: 200px;" class="my-3">
        <div class="mt-4">
            <p>Para más información o asistencia, contáctanos:</p>
            <a href="https://wa.me/1234567890" class="btn btn-success btn-contact">WhatsApp</a>
            <a href="https://facebook.com" class="btn btn-primary btn-contact">Facebook</a>
        </div>
        <a href="shop.php" class="btn btn-secondary mt-4">Volver a la Tienda</a>
    </div>
</body>
</html>
