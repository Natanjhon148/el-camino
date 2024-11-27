<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "el_camino";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Registrar empleado
    $sql_empleado = "INSERT INTO empleados (Nombre, Apellido, Cargo, Correo, Telefono) VALUES (?, ?, ?, ?, ?)";
    $stmt_empleado = $conn->prepare($sql_empleado);
    $stmt_empleado->bind_param("sssss", $nombre, $apellido, $cargo, $correo, $telefono);
    if ($stmt_empleado->execute()) {
        $id_empleado = $stmt_empleado->insert_id;

        // Registrar cuenta
        $sql_cuenta = "INSERT INTO cuenta_empleado (ID_Empleado, Usuario, Contrasena) VALUES (?, ?, ?)";
        $stmt_cuenta = $conn->prepare($sql_cuenta);
        $stmt_cuenta->bind_param("iss", $id_empleado, $usuario, $contrasena);
        if ($stmt_cuenta->execute()) {
            echo "Empleado registrado correctamente.";
        } else {
            echo "Error al registrar la cuenta: " . $conn->error;
        }
    } else {
        echo "Error al registrar el empleado: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado</title>
    <style>
        /* General */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #d3e4fd, #a8c0f0);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Login Form */
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            font-size: 1.8rem;
            color: #1d3557;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-label {
            font-size: 1rem;
            font-weight: bold;
            color: #457b9d;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #457b9d;
            box-shadow: 0 0 5px rgba(69, 123, 157, 0.5);
        }

        .btn-primary {
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: #e63946;
            font-size: 0.9rem;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }

            .login-container h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* General */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #d3e4fd, #a8c0f0);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .form-container h1 {
            font-size: 1.8rem;
            color: #1d3557;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-label {
            font-size: 1rem;
            font-weight: bold;
            color: #457b9d;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #457b9d;
            box-shadow: 0 0 5px rgba(69, 123, 157, 0.5);
        }

        .btn-primary {
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: #e63946;
            font-size: 0.9rem;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .form-container {
                padding: 20px;
            }

            .form-container h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Registrar Empleado</h1>
        <form action="register_empleado.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" id="cargo" name="cargo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
