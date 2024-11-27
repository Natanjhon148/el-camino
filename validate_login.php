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

// Capturar datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Verificar usuario y contraseña
$sql = "SELECT * FROM cuenta_cliente WHERE Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['Contrasena'])) {
        $_SESSION['cliente_id'] = $row['ID_Cliente'];
        $_SESSION['usuario'] = $usuario;

        // Verificar si ya existe un carrito activo
        $id_cliente = $_SESSION['cliente_id'];
        $sql_carrito = "SELECT ID_Carrito FROM carrito WHERE ID_Cliente = ? AND Estado = 'En progreso'";
        $stmt_carrito = $conn->prepare($sql_carrito);
        $stmt_carrito->bind_param("i", $id_cliente);
        $stmt_carrito->execute();
        $result_carrito = $stmt_carrito->get_result();

        if ($result_carrito->num_rows == 0) {
            // Crear un carrito si no existe
            $sql_insert = "INSERT INTO carrito (ID_Cliente, Subtotal, Total, Estado) VALUES (?, 0, 0, 'En progreso')";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("i", $id_cliente);
            $stmt_insert->execute();
            $_SESSION['id_carrito'] = $stmt_insert->insert_id;
        } else {
            $row_carrito = $result_carrito->fetch_assoc();
            $_SESSION['id_carrito'] = $row_carrito['ID_Carrito'];
        }

        header("Location: shop.php");
    } else {
        echo "Contraseña incorrecta. <a href='login.php'>Intenta de nuevo</a>";
    }
} else {
    echo "Usuario no encontrado. <a href='login.php'>Intenta de nuevo</a>";
}

$conn->close();
?>
