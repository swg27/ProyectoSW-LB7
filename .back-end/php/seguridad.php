<?
//Inicio la sesión
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["autentificado"] != "ALUMNO" && $_SESSION["autentificado"] != "PROFESOR" ) {
 //si no existe, envio a la página de autentificación
 header("Location: index.php");
 //además salgo de este script
 exit();
}
?>

