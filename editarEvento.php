<?php
// Incluir archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se proporcionó el ID del evento
if (isset($_GET['idEvento'])) {
    $evento_id = $_GET['idEvento'];

    // Consulta SQL para obtener los detalles del evento
    $query = "SELECT * FROM evento WHERE idEvento = ?";
    $stmt = sqlsrv_prepare($con, $query, array($evento_id));

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Datos del evento recuperados correctamente
            // Mostrar el formulario de edición con los datos recuperados
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
    <!-- Topbar Start -->
    
    <!-- Topbar End -->


    <!-- Navbar Start -->
<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"><img src="images/dailytec.jfif"> </span>
    </button >
            
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
    <a class="#div1 letras" href="index.html"><span class="iconoflecha" ><img src="images/flecha.png" alt="flecha" class="iconoflecha"></span> Regresar</a>
    </div>
        
<div class="principal">
<form action="conexionEditarEvento.php" method="POST" enctype="multipart/form-data">
      
      <h2 class="datoseventotitulo">Datos del evento</h2>
      

      <div class="col-lg-12">
             <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo $row['nombre']; ?>"> 
                
        <label for="check-creditos" class="label2">Libera créditos<br></label>
           <input class="checklist" type="checkbox" id="check-creditos" name="creditos" onchange="updateHiddenInput(this)">
          <input type="hidden" id="hidden-creditos" name="hidden-creditos" value="0">
            &nbsp;</div>
        <div class="grupo">
           
        
        <div class="grupo col-lg-12">
            
            <label for="imagen">Selecciona una imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" onchange="mostrarImagen(this)">
                        <img id="vista-previa-imagen" src="#" alt="Vista previa de imagen" name="imgEvento">
        </div>

   
        </div>
        <div class="grupo col-lg-6" style="max-width: 0px">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $row['descripcion']; ?></textarea>
            <aside class="asidedis col-lg-9">
                <label for="fecha">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required value="<?php echo $row['fecha_inicio']->format('Y-m-d'); ?>">
                <label for="fecha">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required value="<?php echo $row['fecha_fin']->format('Y-m-d'); ?>">
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
</div>
        <div class="col-11 col-lg-12">
          <button type="submit">Enviar</button>
        </div>
        
</form>
     
    </div>
</body>

</html>
<?php
        } else {
            // No se encontró ningún evento para el ID dado
            echo "Evento no encontrado";
        }
    } else {
        // Error al ejecutar la consulta
        echo "Error en la consulta: " . print_r(sqlsrv_errors(), true);
    }
} else {
    // No se proporcionó el ID del evento
    echo "ID del evento no proporcionado";
}
?>

	
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