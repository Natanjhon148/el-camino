
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_carrito = $_SESSION['id_carrito'];

require_once 'phpqrcode/qrlib.php';
$qr_data = "Pago realizado para el carrito: $id_carrito";
$qr_file = "qrcodes/pago_$id_carrito.png";
QRcode::png($qr_data, $qr_file);

$sql = "UPDATE carrito SET Estado = 'Completado' WHERE ID_Carrito = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_carrito);
$stmt->execute();

echo "<h3>¡Compra finalizada con éxito!</h3>";
echo "<img src='$qr_file' alt='Código QR de Pago'>";

$conn->close();
?>
