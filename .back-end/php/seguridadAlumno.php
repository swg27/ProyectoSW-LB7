<?
//Inicio la sesión
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["usuario"] != "ALUMNO") {
 //si no existe, envio a la página de autentificación
 echo("<script> window.location.assign('../../front-end/php/layaoutProfesor.php') </script>");
 //además salgo de este script
 exit();
}
?> 