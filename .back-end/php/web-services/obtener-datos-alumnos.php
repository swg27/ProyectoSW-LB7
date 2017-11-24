<?php
if(isset($_POST['email']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $nombre = trim($_POST['nombre']);
    $username = trim($_POST['username']);
    $contrasenha = trim($_POST['contrasenha']);
    $rep_contrasenha = trim($_POST['rep_contrasenha']);

    if (empty($email)) {
        echo 'Email vacio';
    } else if (!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email)) {
        echo 'El email no cumple con lo establecido';
    } else if (!preg_match("/^(([a-zA-Z]{1,}\ ){1,10})([a-zA-Z]{1,})$/", $nombre)) {
        echo 'El nombre no cumple con lo establecido';
    } else if (!preg_match("/^(([a-zA-Z0-9\_\-]{1,}))$/", $username)) {
        echo 'El username no cumple con lo establecido';
    } else if ($rep_contrasenha !== $contrasenha) {
        echo 'Las contraseña no concuerdan entre si';
    } else {

        require_once('../../../nusoap/src/nusoap.php');

        //require_once('../../../../..//lib/nusoap-0.9.5/lib/nusoap.php');
        //require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdlcache.php');

        $user = addslashes(htmlspecialchars($_POST['email']));
        $ns = "http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl";
        $soapclient = new nusoap_client($ns, true);

        $result = $soapclient->call('comprobar', array('x' => $user));



        if(trim($result) === "SI"){

            $save_user = true;

            $pass = addslashes(htmlspecialchars(trim($_POST['contrasenha'])));
            $ns2 = "http://localhost:80/SW/ProyectoSW-LB5-SOAP/.back-end/php/web-services/comprobar-contrasena.php?wsdl";
            $soapclient2 = new nusoap_client($ns2, true);

            $passIsValid = $soapclient2->call('verifyPassword', array('pass' => $pass));


            if($passIsValid === 'VALIDA'){

        /* include_once '../../.back-end/.others/.Dbconnect.php';

         $error = false;

         if(!isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
             $sql="INSERT INTO users(email, nombre_apellidos, username, password)
           VALUES ('$email', '$nombre', '$username', '$contrasenha')";
         }
         else {
             $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
             $limite_kb = 16384;

             if (in_array($_FILES['image']['type'], $permitidos) && $_FILES['image']['128'] <= $limite_kb * 1024) {

                 // Archivo temporal
                 $imagen_temporal = $_FILES['image']['tmp_name'];

                 // Tipo de archivo
                 $tipo = $_FILES['image']['type'];

                 $data = file_get_contents($imagen_temporal);

                 $data=$conn->real_escape_string($data);

                 $sql="INSERT INTO users(email, nombre_apellidos, username, password, tipo_imagen, imagen)
           VALUES ('$email', '$nombre', '$username', '$contrasenha', '$tipo', '$data')";} else {
                 echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
             }
         }
         if(!mysqli_query($conn, $sql)){
             echo "<p> <button onclick='window.history.back()'>Volver atras</button></p>";
             die('Error: ' . mysqli_error($conn));
         }



         mysqli_close($conn);
         clearstatcache();*/
             echo trim($result);
             }else{
                echo " eres un usuario valido pero la contrasenha: $pass esta contenida como invalida";
            }

        }else{
            echo trim($result);
        }
    }
}else{echo "FAIL! email";}

?>

