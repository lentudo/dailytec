<?php
session_start(); // Iniciar sesión al principio del script

include('conexion.php'); // Incluye tu script de conexión a la base de datos

$error = ""; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta para verificar si el correo existe en la base de datos
    $query = "SELECT idUsuario, contraseña FROM usuario WHERE correo = ?";
    $stmt = sqlsrv_prepare($con, $query, array($correo));

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // El correo existe en la base de datos, ahora verificar la contraseña
            $hashedPassword = $row['contraseña'];
            if ($password === $hashedPassword) {
                // Contraseña correcta
                $_SESSION['id'] = $row['idUsuario']; // Almacena el ID del usuario en la sesión
                $_SESSION['email'] = $correo; // Almacena el correo en la sesión si es necesario
                header("Location: index.php"); // Redirige a una página de bienvenida
                exit();
            } else {
                // Contraseña incorrecta
                $error = "Contraseña incorrecta.";
            }
        } else {
            // El correo no existe en la base de datos
            $error = "No existe usuario con ese correo.";
        }
    } else {
        $error = "Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de error</title>
    <style>
        body {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
            font-family: Arial, sans-serif; /* Fuente predeterminada */
        }
        .notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f44336;
            color: white;
            text-align: center;
            padding: 16px;
            border-radius: 5px;
            z-index: 1000;
        }
        #retryButton {
            display: none;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #FFA500; /* Cambiar el color a naranja */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="notification" class="notification">
        <?php echo $error; ?>
        <button id="retryButton">Reintentar</button>
    </div>

    <script>
        // Mostrar la notificación si hay un mensaje de error
        <?php if ($error) : ?>
            document.getElementById("notification").style.display = "block";
            document.getElementById("retryButton").style.display = "block";
        <?php endif; ?>

        // Redirigir a la página de inicio de sesión al hacer clic en el botón "Reintentar"
        document.getElementById("retryButton").addEventListener("click", function() {
            window.location.href = "Login.php";
        });
    </script>
    <!-- Aquí va el resto de tu código HTML -->
</body>
</html>




    


