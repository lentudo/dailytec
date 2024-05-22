<?php
	session_start();  // Iniciar la sesión PHP

	if (!isset($_SESSION['email'])) {
		// Si no hay sesión de usuario, redirigir al login
		header("Location: Login.php");
		exit();
	}

	// Si hay sesión, recuperar ID del usuario
	$id = $_SESSION['id'];

	//Poner datos en página inicial del usuario
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
    <link href="css/ROMAN.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"><img src="images/dailytec.jfif"> </span>
            </button>

            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <a class="nav-item nav-link active"><img src="images/escudo.png" class="size"></a>
                <a href="index.html" class="nav-item nav-link active"><img src="images/dailytec.jfif" class="size"></a>
                <div class="navbar-nav mr-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Eventos</a>
                    <a href="calendario.php" class="nav-item nav-link">Calendario</a>
                    <a href="single.html" class="nav-item nav-link">Historial</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">Perfil</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="perfil.php" class="dropdown-item">Mi perfil</a>
                            <a href="gestU.php" class="dropdown-item">Gestionar Usuarios</a>
                            <a href="Login.php" class="dropdown-item">Cerrar Sesión</a>
                        </div>
                    </div>
                    <a href="perfil.php" class="nav-item nav-link"><img src="images/userimg.png" class="size2"></a>
                    <a href="perfil.php" class="nav-item nav-link">
                        <div id="username" name="username"> <?php echo htmlspecialchars($nombreCompleto); ?></div>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <div id="div1">
        <a class="#div1 letras" href="index.php"><span class="iconoflecha" ><img src="images/flecha.png" alt="flecha" class="iconoflecha"></span> Regresar</a>
    </div>
    <div class="principal">
        <form action="conexionCrearActividad.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="idEvento" value="<?php echo $evento_id; ?>">
            <h2 class="datoseventotitulo">Datos del evento</h2>
            <div class="col-lg-12">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="check-creditos" class="label2">Libera créditos<br></label>
                <input class="checklist" type="checkbox" id="check-creditos" name="creditos" onchange="updateHiddenInput(this)">
                <input type="hidden" id="hidden-creditos" name="hidden-creditos" value="0">
                &nbsp;
            </div>
            <div class="grupo">
                <div class="grupo col-lg-12">
                    <label for="imagen">Selecciona una imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" onchange="mostrarImagen(this)">
                    <img id="vista-previa-imagen" src="#" alt="Vista previa de imagen" name="imgEvento">
                </div>
            </div>
            <div class="grupo col-lg-6" style="max-width: 0px">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                <aside class="asidedis col-lg-9">
                    <label for="fecha">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                    <label for="fecha">Fecha Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" required>
                    <label for="hora_inicio">Hora de inicio:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" required>
                    <label for="hora_fin">Hora de fin:</label>
                    <input type="time" id="hora_fin" name="hora_fin" required>    
                </aside>
            </div>
            <div class="grupo1 col-lg-6">
                <label for="carrera" name="carreraCombo" id="carreraCombo" >Carrera:</label>
                <input type="hidden" name="carreraIndex" id="carreraIndex">
                <select id="carrera" name="carrera" required onchange="updateIndexCar()">
                    <option value="0">Seleccionar..</option>
                    <option value="1">Arquitectura</option>
                    <option value="2">Ingeniería Bioquímica</option>
                    <option value="3">Ingeniería Civil</option>
                    <option value="4">Ingeniería Eléctrica</option>
                    <option value="5">Ingeniería en Gestión Empresarial</option>
                    <option value="6">Ingeniería Ingeniería en Sistemas Computacionales</option>
                    <option value="7">Ingeniería Industrial</option>
                    <option value="8">Ingeniería Mecatrónica</option>
                    <option value="9">Ingeniería Química</option>
                    <option value="10">Licenciatura en Administración</option>
                </select>
                <section class="col-lg-9" id="delcuadro">
                    <label for="tipo_evento">Tipo de Evento:</label>
                    <select id="tipo_evento" name="tipo_evento" required onchange="cambiarColor()">
                        <option value="0">Seleccionar..</option>
                        <option value="1">Evento Oficial</option>
                        <option value="2">Extraescolar</option>
                        <option value="3">Tutoría</option>
                        <option value="4">Jornada Académica</option>
                        <option value="5">Vinculación</option>
                    </select>
                    <label for="cuadrito" class="label1">Color representativo del evento:<br></label>
                    <div class="col-1 col-lg-1 offset-lg-1" id="cuadrito">&nbsp;</div>
                </section>
                <section class="col-lg-12">&nbsp;</section>
                <label for="modalidad">Modalidad:</label>
                <select id="modalidad" name="modalidad" required>
                    <option value="0">Seleccionar..</option>
                    <option value="1">Presencial</option>
                    <option value="2">Virtual</option>
                </select>
                <div style="color: black">&nbsp;Lugar:</div>
                <input type="text" id="lugar" name="lugar" required>
            </div>
            <div class="col-11 col-lg-12">
               <a type= "submit" href="conexionCrearActividad.php?idEvento=<?php echo $idEvento; ?>" class="btn" style="background-color: orange; color:black">Enviar</a>
  

            </div>
        </form>
    </div>
</body>
</html>

<script>
    function cambiarColor() {
        var tipoEventoSelect = document.getElementById("tipo_evento");
        var cuadrito = document.getElementById("cuadrito");

        // Obtenemos el valor seleccionado
        var valorSeleccionado = tipoEventoSelect.value;

        // Definimos el color correspondiente para cada valor
        var color;
        switch (valorSeleccionado) {
            case "1":
                color = "orange";
                break;
            case "2":
                color = "green";
                break;
            case "3":
                color = "blue";
                break;
            case "4":
                color = "purple";
                break;
            case "5":
                color = "red";
                break;
            default:
                color = "transparent"; // Si se selecciona "Seleccionar.."
                break;
        }

        // Cambiamos el color del cuadrito
        cuadrito.style.backgroundColor = color;
    }

    function mostrarImagen(input) {
        const vistaPrevia = document.getElementById('vista-previa-imagen');
        if (input.files && input.files[0]) {
            const lector = new FileReader();
            lector.onload = function(e) {
                vistaPrevia.src = e.target.result;
            }
            lector.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    function updateIndexCar() {
        // Obtener el índice seleccionado
        var indexcar = document.getElementById("carrera").selectedIndex;
        // Asignar el valor del índice al campo oculto
        document.getElementById("carreraIndex").value = indexcar;
    }
</script>

<script>
    function updateHiddenInput(checkbox) {
        var hiddenInput = document.getElementById('hidden-creditos');
        if (checkbox.checked) {
            hiddenInput.value = '1';
        } else {
            hiddenInput.value = '0';
        }
    }
</script>

