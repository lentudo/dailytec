<?php
    session_start();  // Iniciar la sesión PHP

    if (!isset($_SESSION['email'])) {
        // Si no hay sesión de usuario, redirigir al login
        header("Location: Login.php");
        exit();
    }

    // Si hay sesión, recuperar ID del usuario
    $id = $_SESSION['id'];

    // Incluir archivo de conexión a la base de datos
    include('conexion.php');

    // Consulta SQL para obtener el nombre y apellido paterno del usuario basado en el ID
    $queryuser = "SELECT nombre as name, apellido_paterno FROM usuario WHERE idUsuario = ?";
    $stmt = sqlsrv_prepare($con, $queryuser, array($id));

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Los datos del usuario se han recuperado correctamente
            $nombreUsuario = $row['name'];
            $apellidoPaterno = $row['apellido_paterno'];
            $nombreCompleto = $nombreUsuario . ' ' . $apellidoPaterno;
        } else {
            // No se encontró ningún usuario para el ID dado
            $nombreCompleto = "Usuario Desconocido";
        }
    } else {
        // Error al ejecutar la consulta
        $nombreCompleto = "Error al recuperar el nombre de usuario";
    }

    // Para actividad
    $nom = $_POST["nombre"];
    $des = $_POST["descripcion"];
    $modalidad = $_POST["modalidad"];
    $lugar = $_POST["lugar"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
	$tipo_evento = $_POST["tipo_evento"];
	$idEvento = $_POST['idEvento'];


    // Manejo de la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    $imagen_destino = 'uploads/' . $imagen_nombre;

    if (move_uploaded_file($imagen_temporal, $imagen_destino)) {
        // La imagen se cargó correctamente, ahora puedes guardar la ruta en la base de datos
    } else {
        // Hubo un error al cargar la imagen
    }

    // Preparar la consulta SQL
    $query = "INSERT INTO ACTIVIDAD (nombre, descripcion, imagen, modalidad, lugar, fecha_inicio, fecha_fin, hora_inicio, hora_fin, tipo_evento, fk_evento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Parámetros para la consulta SQL
    $paramsActividad = array($nom, $des, $imagen_destino, $modalidad, $lugar, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $tipo_evento, $idEvento);

    // Ejecutar la consulta SQL
    $res = sqlsrv_prepare($con, $query, $paramsActividad);

    if ($res) {
        if (sqlsrv_execute($res)) {
            echo "Datos de evento insertados correctamente";
        } else {
            // Hubo un error al ejecutar la consulta, obtén los detalles del error
            $errors = sqlsrv_errors();
            echo "Error al insertar: " . print_r($errors, true);
        }
    } else {
        // Hubo un error al preparar la consulta
        $errors = sqlsrv_errors();
        echo "Error al preparar la consulta: " . print_r($errors, true);
    }


?>
