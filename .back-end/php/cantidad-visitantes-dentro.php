
<?php

//ob_start();
//session_start();

//if(isset($_SESSION['user'])!=""){
    //  header("Location: index.php");
//}

if(isset($_GET['user']))
{
    $email = $_GET['user'];
    if (empty($email)) {
        echo 'error 1';
    } else if (!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email)) {
        echo 'error 2';
    } else {

        include_once '../.others/.Dbconnect.php';

        $sql = "SELECT email FROM users WHERE email='$email'";

        if (!mysqli_query($conn, $sql)) {
            echo "<script>alert('Credenciales incorrectas!');</script>";
            die('Error: ' . mysqli_error($conn));
        }else{

            $user = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($user);

            if($email == $row['email']) {

                $count = new SimpleXMLElement("<counter><contador></contador></counter>");

                $counter = simplexml_load_file('../xml/contador.xml');
                $contador = $counter->children();
                $count->contador=$counter->contador[0]+1;
                $domxml = new DOMDocument('1.0');
                $domxml->preserveWhiteSpace = false;
                $domxml->formatOutput = true;
                $domxml->loadXML($count->asXML()); /* $xml es nuestro SimpleXMLElement a guardar*/
                $domxml->save('../xml/contador.xml');


                $n = $count->contador[0];
                echo $n;

            }else
            {
                echo " Solo pueden acceder usuarios registrados. ";
                echo "<a href='../../php/register.php'>Registrarse</a>";
            }
        }
    }
}
else
{
    echo "Error";
}

?>
