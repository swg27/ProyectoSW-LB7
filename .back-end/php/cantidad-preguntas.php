
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
            echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
            die('Error: ' . mysqli_error($conn));
        }else{

            $user = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($user);

            if($email == $row['email']) {

            $quant_quest=mysqli_query($conn, "SELECT email, count(*) AS counter FROM preguntas");
            $quant_user=mysqli_query($conn, "SELECT email, count(*) AS counter FROM preguntas WHERE email='$email'");

                $rowx = mysqli_fetch_array($quant_user);
                $rowy = mysqli_fetch_array($quant_quest);

                $result .=  $rowx['counter'];
                $result .='/';
                $result .= $rowy['counter'];

                echo $result;

                $quant_quest->close();
                $quant_user->close();
                mysqli_close($conn);

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
