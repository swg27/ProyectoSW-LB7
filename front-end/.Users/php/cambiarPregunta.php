<!DOCTYPE html>
<?php

include_once '../../../.back-end/php/seguridad.php';

if(isset($_SESSION['ID']))
{
    $email = $_SESSION['email'];
    if (empty($email)) {
        echo 'error 1';
    } else if (!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email)) {
        echo 'error 2';
    } else {

        include_once '../../../.back-end/.others/.Dbconnect.php';

        $error = false;

        $sql = "SELECT email, imagen FROM users WHERE email='$email' ";

        if (!mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
            die('Error: ' . mysqli_error($conn));
        }else{

        $user = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($user);


         if($email == $row['email']) {

        $QueryCollectionPreguntas = mysqli_query($conn, "SELECT cod_pregunta, pregunta FROM preguntas");





?>



<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='../../estilos/style.css'/>
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='../../estilos/wide.css'/>
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='../../estilos/smartphone.css'/>

</head>
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
    #result {
        margin: auto;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

    function ajaxRequest(){
        var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"]; //activeX versions to check for in IE
        if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
            for (var i=0; i<activexmodes.length; i++){
                try{
                    return new ActiveXObject(activexmodes[i]);
                }
                catch(e){
                    //suppress error
                }
            }
        }
        else if (window.XMLHttpRequest) // if Mozilla, Safari etc
            return new XMLHttpRequest();
        else
            return false;
    }

    function ajaxGet() {
        console.log('TRACE 1: ajaxGet ')
        var mygetrequest = new ajaxRequest();
        mygetrequest.onreadystatechange = function () {
            if (mygetrequest.readyState == 4) {
                if (mygetrequest.status == 200 || window.location.href.indexOf("http") == -1) {
                    document.getElementById("result").innerHTML = mygetrequest.responseText;
                }
                else {
                    alert("An error has occured making the request");
                }
            }
        }
        var cod = $('#listaPreguntas option:selected').val();
        console.log(cod);
        mygetrequest.open("GET","http://localhost:80/SW/ProyectoSW-LB7/.back-end/php/obtenerPregunta.php?cod_pregunta=" + cod, true);
        mygetrequest.send(null);

    }

    function ajaxPost(){
        console.log('TRACE 1: ajaxPost()');
        var mypostrequest=new ajaxRequest();
        mypostrequest.onreadystatechange=function(){
            if (mypostrequest.readyState===4){
                if (mypostrequest.status===200 || window.location.href.indexOf("http")===-1){
                    document.getElementById("blk").innerHTML = mypostrequest.responseText;
                }
                else{
                    alert("An error has occured making the request");
                }
            }
        };
        console.log('TRACE 2: ajaxPost()');
        var cod_pregunta = $('#listaPreguntas option:selected').val();
        var userId = encodeURIComponent(document.getElementById("e-mail").value);
        var nivel = encodeURIComponent(document.getElementById("lvl").value);
        var tema = encodeURIComponent(document.getElementById("tm").value);
        var pregunta = encodeURIComponent(document.getElementById("Qst").value);
        var respuesta = encodeURIComponent(document.getElementById("ans").value);
        var incorrecta1 = encodeURIComponent(document.getElementById("noAns1").value);
        var incorrecta2 = encodeURIComponent(document.getElementById("noAns2").value);
        var incorrecta3 = encodeURIComponent(document.getElementById("noAns3").value);
        var parameters="cod_pregunta="+cod_pregunta+"&email="+userId+"&level="+nivel+"&tema="+tema+"&question="+pregunta+"&correctAns="+respuesta+"&incorrectAns1="+incorrecta1+"&incorrectAns2="+incorrecta2+"&incorrectAns3="+incorrecta3;
       console.log(parameters);
        mypostrequest.open("POST", "http://localhost:80/SW/ProyectoSW-LB7/.back-end/php/actualizarPregunta.php", true);
        mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        mypostrequest.send(parameters);

        console.log('TRACE N: ajaxPost()');


    }

</script>
<body>
<div id='page-wrap'>
        <header class='main' id='h1'>
            <div id='ident' align="center">
                <table id="t_iden" width="64px">
                    <tr>
                        <td>
                            <p align='center' class='user'><strong>Bienvenido: </strong><?php echo $email?></p>
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
        <span><a href='creditos.php'>Creditos</a></span>
        <span><a href='gestion-preguntas.php'>Gestión de preguntas</a></span>

    </nav>
    <section class="main" id="s1">

        <div>
           <form >
               <?php
                   echo '<select name="select" id="listaPreguntas" onchange="ajaxGet()">
                                <option value="">Selecione [cod] de la pregunta.</option>';
                   while($row2=mysqli_fetch_array( $QueryCollectionPreguntas))
                   {
                   echo '<option id="' . htmlspecialchars($row2['cod_pregunta']) . '" value="' . htmlspecialchars($row2['cod_pregunta']) . '">['
                       . htmlspecialchars($row2['cod_pregunta']).'] '. '</option>';
                   }
                   echo '</select>';
                ?>
           </form>
            <div id="result" align="center" "></div>
        </div>

    </section>
            </div>
    <footer class='main' id='f1'>
        <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
        <a href='https://github.com/swg27/'>Link GITHUB</a>
    </footer>
</div>
</body>
</html>

<?php

mysqli_close($conn);
clearstatcache();
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