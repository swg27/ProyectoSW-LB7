<?php

if(isset($_REQUEST['submiter']))
{
$email = trim($_GET['email']);
$contrasenha = trim($_GET['contrasenha']);

if(empty($email))
{
    echo "<script type='text/javascript'>alert('Email vacio');</script>";
}
else if(!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email))
{
    echo "<script type='text/javascript'>alert('Error 1');</script>";
}
else if(!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\-\_\\]{4,20}$/", $contrasenha))
{
    echo "<script type='text/javascript'>alert('Error 3');</script>";
}


else
{
//ob_start();
//session_start();

include_once '../../.back-end/.others/.Dbconnect.php';

$error = false;

$sql="SELECT email, password FROM users WHERE email='$email' AND password='$contrasenha' ";

if(!mysqli_query($conn, $sql)){
    echo "<script type='text/javascript'>alert('Error!');</script>";
    die('Error: ' . mysqli_error($conn));
}

echo "<script type='text/javascript'>alert('usuario registrado!');</script>";

mysqli_close($conn);
clearstatcache();

}
}
?>