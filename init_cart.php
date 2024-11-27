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

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['cliente_id'])) {
    die("No has iniciado sesión. <a href='login.php'>Iniciar sesión</a>");
}

$id_cliente = $_SESSION['cliente_id'];

// Verificar si ya existe un carrito activo para este cliente
$sql = "SELECT ID_Carrito FROM carrito WHERE ID_Cliente = ? AND Estado = 'En progreso'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Crear un nuevo carrito para el cliente
    $sql_insert = "INSERT INTO carrito (ID_Cliente) VALUES (?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("i", $id_cliente);
    $stmt_insert->execute();
    $id_carrito = $stmt_insert->insert_id;
} else {
    $row = $result->fetch_assoc();
    $id_carrito = $row['ID_Carrito'];
}

// Guardar el ID del carrito en la sesión
$_SESSION['id_carrito'] = $id_carrito;

$conn->close();
?>
