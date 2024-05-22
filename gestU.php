



<?php
session_start();  // Iniciar la sesión PHP

if (!isset($_SESSION['email'])) {
    // Si no hay sesión de usuario, redirigir al login
    header("Location: Login.php");
    exit();
}

// Si hay sesión, recuperar ID del usuario
$id = $_SESSION['id'];
include('conexion.php');

// Consulta SQL para obtener datos del usuario basado en el ID
$queryuser = "SELECT u.nombre AS nom_usuario, u.apellido_paterno, u.apellido_materno, u.no_control, u.contraseña, u.correo, c.nombre AS nom_carrera
              FROM usuario u
              INNER JOIN alumno a ON a.fk_usuario = u.idUsuario
              INNER JOIN carrera c on c.idCarrera = a.fk_carrera
              WHERE a.fk_usuario = ?;";

$stmt = sqlsrv_prepare($con, $queryuser, array(&$id));

if ($stmt) {
    sqlsrv_execute($stmt);
} else {
    echo "Error al preparar consulta SQL";
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Perfil del Usuario</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .btn-eliminar {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-editar {
            background-color: orange;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-eliminar:hover, .btn-editar:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Información de Usuario</h2>
    <table border="1">
        <tr>
            <th>Número de control</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Carrera</th>
            <th>Contraseña</th>
            <th>Acciones</th>
        </tr>
        <?php
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['no_control']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom_usuario']) . ' ' . htmlspecialchars($row['apellido_paterno']) . ' ' . htmlspecialchars($row['apellido_materno']) . "</td>";
            echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom_carrera']) . "</td>";
            echo "<td>" . htmlspecialchars($row['contraseña']) . "</td>";
            echo "<td>";
            echo "<button onclick=\"eliminarRegistro('" . htmlspecialchars($row['no_control']) . "')\" class='btn-eliminar'>Eliminar</button> ";
            echo "<button onclick=\"editarRegistro('" . htmlspecialchars($row['no_control']) . "')\" class='btn-editar'>Editar</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<script>
    function eliminarRegistro(noctrl) {
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            window.location.href = "gestU.php?eliminar=" + noctrl;
        }
    }

    function editarRegistro(noctrl) {
        window.location.href = "editar.php?editar=" + noctrl;
    }
</script>
	

	
</body>
</html>
