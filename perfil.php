<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

include('conexion.php');

$id = $_SESSION['id'];

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
    $rutaImagen = 'profiles/' . $_FILES['imagen']['name'];

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        $queryActualizarImagen = "UPDATE usuario SET foto_perfil = ? WHERE idUsuario = ?";
        $stmt = sqlsrv_prepare($con, $queryActualizarImagen, array($rutaImagen, $id));

        if ($stmt && sqlsrv_execute($stmt)) {
            // La imagen se ha guardado correctamente en la base de datos
        } else {
            // Error al actualizar la ruta de la imagen en la base de datos
        }
    } else {
        // Error al mover la imagen al directorio de destino
    }
} else {
    // Código para manejar el caso en que no se haya enviado una imagen
}

$queryuser = "SELECT U.nombre, U.apellido_paterno, U.apellido_materno, U.correo, nv.rol, U.no_control, C.nombre AS carrera, U.foto_perfil
    FROM usuario U
    INNER JOIN Alumno A ON A.fk_usuario = U.idUsuario
    INNER JOIN CARRERA C ON C.idCarrera = A.fk_carrera
    INNER JOIN NvAcceso NV ON NV.nvAcceso = U.fk_acceso
    WHERE U.idUsuario = ?;";

$stmt = sqlsrv_prepare($con, $queryuser, array($id));

if ($stmt && sqlsrv_execute($stmt)) {
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nombreUsuario = $row['nombre'];
        $apellidoPaterno = $row['apellido_paterno'];
        $apellidoMaterno = $row['apellido_materno'];
        $nombreCompleto = $nombreUsuario . ' ' . $apellidoPaterno;
        $correo = $row['correo'];
        $rol = $row['rol'];
        $nctrl = $row['no_control'];
        $carrera = $row['carrera'];
        $fotoPerfil = $row['foto_perfil']; // Ruta de la foto de perfil
    } else {
        $nombreCompleto = "Usuario Desconocido";
    }
} else {
    $nombreCompleto = "Error al recuperar el nombre de usuario";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BizNews - Free News Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
    body {
}
    </style>
</head>

<body>
    <!-- Navbar Start -->
	<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5"> 
	<a class="nav-item active"><img src="images/escudo.png" class="size"></a>
	<a href="index.html" class="nav-item active"><img src="images/dailytec.jfif" class="size"></a> 
  <div class=".navbar-nav .mr-auto .py-0" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item nav-link active"> <a class="nav-link" href="#">EVENTOS</a></li>
      <li class="nav-item nav-link active"> <a class="nav-link" href="#">CALENDARIO</a></li>
      <li class="nav-item nav-link active"> <a class="nav-link" href="#">HISTORIAL</a></li>
	 <li class="nav-item dropdown nav-link active"> <a class="nav-link dropdown-toggle" data-toggle="dropdown">Perfil</a>
		 <div class="dropdown-menu rounded-0 m-0">
                            <a href="perfil.php" class="dropdown-item">Mi perfil</a>
						  	<a href="gestU.php" class="dropdown-item">Gestionar Usuarios</a>
                            <a href="Login.php" class="dropdown-item">Cerrar Sesión</a>
        </div>
	  </li>
	<li >  <a href="perfil.php" class="nav-item nav-link"><img src="<?php echo $fotoPerfil  ?>" class="size2"></a></li>
    </ul>
    
  </div>
	<div>&nbsp; <?php echo htmlspecialchars($nombreCompleto); ?></div>
	<form class="form-inline my-2 my-lg-0">
		
		<div class="input-group ml-auto d-none d-lg-flex nav-link nav-item active"   style="width: 100%; max-width: 300px;">
				  
                   <a class="nav-link dropdown-toggle  fa fa-search" data-toggle="dropdown">&nbsp; Buscar</a>
                      <div class="dropdown-menu rounded-0 m-0">
                            <a href="#micarrera" class="dropdown-item">Mi carrera</a>
						  	<a href="#creds" class="dropdown-item">Libera Créditos</a>
                            <a href="#oficial" class="dropdown-item">Eventos oficiales</a>
						  	<a href="#extra" class="dropdown-item">Extraescolares</a>
						  	<a href="#tutos" class="dropdown-item">Tutorías</a>
						  	<a href="#jornada" class="dropdown-item">Jornada Académica</a>
						  	<a href="#vinc" class="dropdown-item">Vinculación</a>
						  
                          
                        </div>
                      
    </form>
	
</nav>
	
	
    <!-- Navbar End -->

<form action="perfil.php" method="post" enctype="multipart/form-data">
<div class="divInicio align-content-center" style="text-align: center">
  <input class="input" type="file" id="imagen" name="imagen" accept="image/*" onchange="mostrarImagen(this)"> <button type="submit">Subir Imagen</button>
  <div class="imagenPerfil"> <img src="<?php echo $fotoPerfil; ?>" alt="Vista previa de imagen" id="vista-previa-imagen">
      
</div></div>

<body bgcolor="#000000">

    
<div class="contai"> 
    <div class="letraPerfil">NOMBRE USUARIO</div>
    <div class="divsPerfil" name="usuario" id="usuario" > &nbsp; <?php echo htmlspecialchars($nombreCompleto); ?></div>
<div class="letraPerfil">CORREO</div>
                <div class="divsPerfil" id="correo" name="correo"> &nbsp; <?php echo htmlspecialchars($correo); ?> </div> 
	<div class="letraPerfil" >ROL</div>
          		<div class="divsPerfil" id="rol" name="rol"> <?php echo htmlspecialchars($rol); ?> &nbsp; </div> 
          <div class="letraPerfil">CARRERA</div>
          		<div class="divsPerfil" id="carrera" name="carrera"> <?php echo htmlspecialchars($carrera); ?></div> 
          <div class="letraPerfil">NUMERO CONTROL</div>
          		<div class="divsPerfil" id="control" name="control"> &nbsp;  <?php echo htmlspecialchars($nctrl); ?> </div> 
