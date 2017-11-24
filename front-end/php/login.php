<!DOCTYPE html>

<?php
if (isset($_SESSION['usuario'])){
    if ($_SESSION['usuario'] == 'ALUMNO'){
        echo("<script> window.location.assign('../.Users/php/layaoutAlumno.php') </script>");
    }else{
        echo("<script> window.location.assign('../.Users/php/layaoutProfesor.php') </script>");
    }
}

if(isset($_POST['submiter']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
$email = trim($_POST['email']);
$contrasenha = trim($_POST['contrasenha']);

if(empty($email))
{
    echo "<script type='text/javascript'>alert('Email vacio');</script>";
}
else if(!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email))
{
    echo "<script type='text/javascript'>alert('Error de credenciales 1');</script>";
}
else if(!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\\\-\_]{6,20}$/", $contrasenha))
{
    echo "<script type='text/javascript'>alert('Error de credenciales 2');</script>";
}else {

//ob_start();
//session_start();
include_once '../../.back-end/.others/.Dbconnect.php';

$error = false;

$sql="SELECT email, password FROM users WHERE email='$email' AND password='$contrasenha' ";

if(!mysqli_query($conn, $sql)){
    echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
    die('Error: ' . mysqli_error($conn));
}

$user = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($user);
$e_mail = $row['email'];
$pass = $row['password'];
mysqli_close($conn);
clearstatcache();

if($contrasenha == $pass && $email == $e_mail) {

    session_start();
    $_SESSION['ID']=$email;
    if($email == ':web000@ehu.es'){
        $_SESSION['usuario']= "PROFESOR";
        $_SESSION['autentificado'] = 'PROFESOR';
        $_SESSION['email'] = $email;
        echo ("<script>alert('El login se ha hecho adecuadamente, ahora puedes modificar preguntas. Bienvenido:'$e_mail)</script>");
        echo("<script> window.location.assign('../.Users/php/cambiarPregunta.php') </script>");
    } else {
        $_SESSION['usuario'] = 'ALUMNO';
        $_SESSION['autentificado'] = 'ALUMNO';
        $_SESSION['email'] = $email;
        echo ("<script>alert('El login se ha hecho adecuadamente, ahora puedes enviar preguntas. Bienvenido:'$e_mail)</script>");
       // echo("<script> window.location.assign('../.Users/php/jugar.php') </script>");
        echo("<script> window.location.assign('../.Users/php/layout.php') </script>");
    }
   // header("Location: ../.Users/html/layout.php?!=$email&?=$word");
        }else{
    echo "<script type='text/javascript'>alert('Error de credenciales 3');</script>";
}
    }
}
?>

<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Login</title>
    <link rel='stylesheet' type='text/css' href='../estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='../estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='../estilos/smartphone.css' />

    <style>
        div #blk{
            background-color: rgba(10, 56, 75, 0.78);
            width:435px;
            height:200px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        table {
            margin-bottom: auto;
            border:0.25px solid rgba(10, 131, 169, 0.93);
        }

        form   {;
            background-color: #d2d2d2;
            width:400px;
            height:545px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }
    </style>
</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <span class="right"><a href="register.php">Registrarse</a></span>
        <span class="right" style="display:none;"><a href="/logout">Logout</a></span>
        <h2>Quiz: el juego de las preguntas</h2></br>
        <h3>Login</h3>
    </header>
    <div style="height: auto;">
    <nav class='main' id='n1' role='navigation'>
        <span><a href='../html/layout.html'>Inicio</a></span>
        <span><a href='../html/creditos.html'>Creditos</a></span>
    </nav>
    <section class="main" id="s1">
        <div align="left"><div id="blk" align="left">
                </br>
                <table border="1">
                    <tr>

                        <form id='freg' name='fregister' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="Post" enctype="multipart/form-data">
                            <td>
                                <?php
                                if(isset($error))
                                {
                                ?>
                    <tr>
                        <td id="error"><?php echo $error; ?></td>
                    </tr>
                    <?php
                    }
                    ?>

                    Email*: &nbsp;<input type="text" size="50" id="e-mail" name="email" placeholder="p.e. pepitoXY" value="<?php if(isset($email)){echo $email;} ?>" /></br>
                    Password*: &nbsp;<input type="password" size="50" id="pass" name="contrasenha" placeholder="p.e. ~!dsd%?@#$^*-_/\101-  o password seguro?" value="<?php if(isset($contrasenha)){echo $contrasenha;} ?>"/></br>
                    <input type="submit" id="submiter" name="submiter" value="Enviar" align="center">&nbsp;
                    <input type=reset value="Clear Form"></br></br>

                    </td>
                    </form>
                    </tr>
                </table>
            </div></div>
    </section>
        <div>
    <footer class='main' id='f1'>
        <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
        <a href='https://github.com/swg27/'>Link GITHUB</a>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file_url").change(function(){
        mostrarImagen(this);
    });
</script>
</body>
</html>



