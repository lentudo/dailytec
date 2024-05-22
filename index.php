<?php
	session_start();  // Iniciar la sesión PHP

	if (!isset($_SESSION['email'])) {
		// Si no hay sesión de usuario, redirigir al login
		header("Location: Login.php");
		exit();
	}

	// Si hay sesión, recuperar ID del usuario
	$id = $_SESSION['id'];


	//Poner datos en pagina inicial del usuario
	// ...código anterior para iniciar sesión y obtener el ID del usuario...
	include('conexion.php');

    // Consulta SQL para obtener el nombre y apellido paterno del usuario basado en el ID
    $queryuser = "SELECT nombre, apellido_paterno FROM usuario WHERE idUsuario = ?";
    $stmt = sqlsrv_prepare($con, $queryuser, array($id));

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Los datos del usuario se han recuperado correctamente
            $nombreUsuario = $row['nombre'];
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
</head>

<body>
    <!-- Topbar Start -->
    
    <!-- Topbar End -->

    <!-- Navbar Start -->
	<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5"> 
	<a class="nav-item active"><img src="images/escudo.png" class="size"></a>
	<a href="index.html" class="nav-item active"><img src="images/dailytec.jfif" class="size"></a> 
  <div class=".navbar-nav .mr-auto .py-0" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item nav-link active"> <a class="nav-link" href="index.php">EVENTOS</a></li>
      <li class="nav-item nav-link active"> <a class="nav-link" href="#">CALENDARIO</a></li>
      <li class="nav-item nav-link active"> <a class="nav-link" href="historial.html">HISTORIAL</a></li>
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


    <!-- Main News Slider Start -->    <!-- Main News Slider End -->


    <!-- Breaking News Start -->    <!-- Breaking News End -->


    <!-- Featured News Slider Start -->
    <div class="container-fluid pt-5 mb-3">
        <div class="container">
          <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">Mi carrera</h4>
			  
          </div>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eventos</title>



	<div class="owl-carousel news-carousel carousel-item-4 position-relative">
	<?php

    if ($con === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = "SELECT C.siglas as siglas, E.fecha_inicio, E.nombre, E.banner, E.idEvento FROM evento E
        INNER JOIN carrera C ON C.idCarrera = E.fk_carrera";
	
    $stmt = sqlsrv_query($con, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo '
			
            <div class="position-relative overflow-hidden" style="height: 300px;">
            <div class="event-container">
                <img class="img-fluid" src="' . $row["banner"] . '">
                <div class="overlay">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">' . $row["siglas"] . '</a>
                        <a class="text-white" href="#"><small>' . $row["fecha_inicio"]->format('M d, Y') . '</small></a>
                    </div>
                    <a class="event-title" href="detallesEvento.php?idEvento=' . $row['idEvento'] . '">' . $row["nombre"] . '</a>
                </div>
            </div>
			<div id="popup" class="popup">
			 
</div>
		</div>
		

        ';
    }

    sqlsrv_free_stmt($stmt);
?>

		</div>
	
	
<style>
		.popup {
  display: none; 
  position: fixed; 
  z-index: 1; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity 
}

/* Popup content */
.popup-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* Show the popup */
.show {
  display: block;
}
	
	
	
	</style>
	
	
	<div id="popup" class="popup">
	  <div class="popup-content">
		<!-- Popup content here -->
		<h4>Popup Content</h4>
		<p>This is the content of the popup.</p>
		<a href="#" class="boton-naranja1" onclick="togglePopup()">Cerrar</a>
	  </div>
	</div>
	
	
	<script>
		
		function togglePopup() {
		  var popup = document.getElementById("popup");
		  popup.classList.toggle("show");
		}

	</script>

	

</body>
</html>
			

			
          
                </div>
        <div class="container">
		 <div class="section-title carrusel2">
                <h4 class="m-0 text-uppercase font-weight-bold">EVENTOS OFICIALES</h4>
            </div>
		<div class="owl-carousel news-carousel carousel-item-4 position-relative">
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    <img id="imgev1" name="imgev1" class="img-fluid h-100" src="img/news-700x435-1.jpg" style="object-fit: cover;">
                    <div class="overlay">
                        <div class="mb-2">
                            <a name="tipo_ev1" class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="">Business</a>
                            <a class="text-white" href=""><small name="fechaev1">Jan 01, 2045</small></a>
                        </div>
                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="" name="descev1" id="descev1">Lorem ipsum dolor sit amet elit...</a>
                    </div>
                </div>
			
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    <img class="img-fluid h-100" src="img/news-700x435-2.jpg" style="object-fit: cover;">
                    <div class="overlay">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="">Business</a>
                            <a class="text-white" href=""><small>Jan 01, 2045</small></a>
                        </div>
                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="">Lorem ipsum dolor sit amet elit...</a>
                    </div>
                </div>
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    <img class="img-fluid h-100" src="img/news-700x435-3.jpg" style="object-fit: cover;">
                    <div class="overlay">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="">Business</a>
                            <a class="text-white" href=""><small>Jan 01, 2045</small></a>
                        </div>
                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="">Lorem ipsum dolor sit amet elit...</a>
                    </div>
                </div>
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    <img class="img-fluid h-100" src="img/news-700x435-4.jpg" style="object-fit: cover;">
                    <div class="overlay">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="">Business</a>
                            <a class="text-white" href=""><small>Jan 01, 2045</small></a>
                        </div>
                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="">Lorem ipsum dolor sit amet elit...</a>
                    </div>
					
                </div>
			
			
			
		</div>
      
    <!-- News With Sidebar End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5"> </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center">&copy; <a href="#">DailyTec</a>. Todos los derechos reservados. 
		
		<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
		
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
   


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
	
	 <a href="CrearEvento.php" ><button class="boton-flotante owl-nav owl-prev font-weight-medium">+ Añadir Evento</button> </a>
</body>

</html>



