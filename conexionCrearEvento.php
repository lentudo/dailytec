<?php
session_start();  // Iniciar la sesión PHP

if (!isset($_SESSION['email'])) {
    // Si no hay sesión de usuario, redirigir al login
    header("Location: Login.php");
    exit();
}

// Si hay sesión, recuperar ID del usuario
$id = $_SESSION['id'];

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener datos del formulario
$nom = $_POST["nombre"];
$des = $_POST["descripcion"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_fin = $_POST["fecha_fin"];
$indexcar = $_POST["carreraIndex"];
$cred = $_POST["hidden-creditos"];

// Verificar si se ha enviado un archivo
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Ruta donde se almacenarán las imágenes subidas
    $upload_dir = "uploads/";

    // Obtener información del archivo subido
    $file_name = $_FILES['imagen']['name'];
    $file_tmp = $_FILES['imagen']['tmp_name'];
    
    // Mover el archivo subido al directorio de carga
    if(move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
        // La imagen se ha subido correctamente, guardamos la ruta en la base de datos
        $banner_url = $upload_dir . $file_name;
    } else {
        echo "Error al subir la imagen";
        exit();
    }
} else {
    echo "No se ha seleccionado ninguna imagen o ocurrió un error durante la carga";
    exit();
}

// Preparar la consulta SQL para insertar el evento en la base de datos
$query = "INSERT INTO EVENTO (nombre, descripcion, fecha_inicio, fecha_fin, liberacion_creditos, fk_carrera, fk_creador, banner) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Parámetros para la consulta
$params = array($nom, $des, $fecha_inicio, $fecha_fin, $cred, $indexcar, $id, $banner_url);

// Ejecutar la consulta
$res = sqlsrv_query($con, $query, $params);

if ($res) {
    echo "Datos de evento insertados correctamente";
} else {
    // Mostrar errores si la consulta falla
    $errors = sqlsrv_errors();
    echo "Error al insertar: " . print_r($errors, true);
}

echo "Índice de carrera seleccionado: " . $indexcar;
?>

