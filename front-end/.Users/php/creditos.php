<!DOCTYPE html>

<?php

include_once '../../../.back-end/php/seguridad.php';

if(isset($_SESSION['ID']))
{
    $email =$_SESSION['email'];
    if (empty($email)) {
        echo 'error 1';
    }else {
//ob_start();
//session_start();

        include_once '../../../.back-end/.others/.Dbconnect.php';

        $error = false;

        $sql = "SELECT email, imagen FROM users WHERE email='$email'";

        if (!mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
die('Error: ' . mysqli_error($conn));
}else{

    $user = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($user);
    mysqli_close($conn);
    clearstatcache();

    if($email == $row['email']) {



            ?>

<html xmlns="http://www.w3.org/1999/html">
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Creditos</title>
      <link rel='stylesheet' type='text/css' href='../../estilos/style.css'/>
      <link rel='stylesheet'
            type='text/css'
            media='only screen and (min-width: 530px) and (min-device-width: 481px)'
            href='../../estilos/wide.css'/>
      <link rel='stylesheet'
            type='text/css'
            media='only screen and (max-width: 480px)'
            href='../../estilos/smartphone.css'/>

	  <style>
          #ident{
              margin: auto;
              background-color: rgba(10, 56, 75, 0.62);
              width:750px;
              height:156px;
              border:1px solid rgba(10, 131, 169, 0.93);
              padding:10px;
          }

          #t_iden{
              background-color: rgba(255, 255, 255, 0.79);
              width:750px;
              height:156px;
              border:1px solid rgba(10, 131, 169, 0.93);
              padding:10px;
          }
          .user {
              margin: auto;
              color: dodgerblue;
          }
		  div #blk{
			  background-color: rgba(255, 235, 205, 0.62);
			  width:465px;
			  height:355px;
			  border:1px solid rgba(10, 131, 169, 0.93);
			  padding:10px;
		  }
	  </style>

  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
        <div id='ident' align="center">
            <table id="t_iden" width="64px">
                <tr>
                    <td>
                        <p align='center' class='user'><?echo $email?></p>
                    </td>
                    <td id='td_img' height="64px">
                        <?php echo '<img id="u_img" height="128px" src="data:image/type;base64,'.base64_encode( $row['imagen']).' "/>'?>
                    </td>
                </tr>
            </table>
        </div>
		<span class="right"><a onclick="alert('Cierre de sesion')" href="../../html/layout.html">Logout</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
      <div style="height: auto;">
      <nav class='main' id='n1' role='navigation'>
		<span><a href='layout.php'>Inicio</a></span>
          <?php if($_SESSION['usuario'] == 'PROFESOR'){
              echo"<span><a href='cambiarPregunta.php'>Modificar preguntas</a></span>";
          }else if($_SESSION['usuario'] == 'ALUMNO') {
              echo "<span><a href='gestion-preguntas.php'>Gestión de preguntas</a></span>";
          }
          ?>
	</nav>
    <section class="main" id="s1">
	<div align="center">
     [Creditos]</br>
		Autores: Sebastian & Sergio</br>
		Especialidad: Ingeniería de Software</br>
		Foto:</br><img src="../resources/img/two-monkeys.jpg" target="_blank" width="320" height="256"></br>
      En el mapa se marcan los municipios de ambos participantes y la localización de la facultad
  </div><div align="center" id ="map">
  </div>
    </section>
      </div>
	<footer class='main' id='f1'>
		<p><a href="https://es.wikipedia.org/wiki/Quiz">Que es un Quiz?</a></p>
		<a href="https://github.com/swg27/">Link GITHUB</a>
	</footer>
  </div>
  <script>

    var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: 43.3118111, lng: -1.9885133}
        });

        // NOTE: This uses cross-domain XHR, and may not work on older browsers.
        map.data.loadGeoJson(
            'map.geojson');
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDs-9wWNPXfKHHVXN3yh1XVj1k414-VVww&callback=initMap">
    </script>
    
</body>
</html>

        <?php
    }else
    {
        echo "\n Solo pueden acceder usuarios registrados. \n";
        echo "<a href='../../php/register.php'>Registrarse</a>";
    }
}
}
}
else
{
    echo "\n Error";
}
    ?>