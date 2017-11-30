<!--?php session_start(); ?-->
<!DOCTYPE html>

<?php

include_once '../../../.back-end/php/seguridadAlumno.php';

 if(isset($_SESSION['ID']))
 {
     $email = $_SESSION['email'];
     if (empty($email)) {
         echo 'error 1';
     } else {


         include_once '../../../.back-end/.others/.Dbconnect.php';

         $error = false;

         $sql = "SELECT email, imagen, isOn FROM users WHERE email='$email' ";

         if (!mysqli_query($conn, $sql)) {
             echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
             die('Error: ' . mysqli_error($conn));
         }else{

             $user = mysqli_query($conn, $sql);
             $row = mysqli_fetch_array($user);


             if($email === $row['email']) {

                 $user_img = $row['imagen'];

                 if($row['isOn']==0) {
                     $sqlUpdate = "UPDATE users SET isOn=1 WHERE email='$email'";
                     $on = mysqli_query($conn, $sqlUpdate);
                     $incr=true;
                 }else{
                     $incr=false;
                 }


           ?>


<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='../../estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='../../estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='../../estilos/smartphone.css' />

    <style>

        #ident {
            margin: auto;
            background-color: rgba(10, 56, 75, 0.62);
            width:750px;
            height:156px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        #t_iden {
            background-color: rgba(255, 255, 255, 0.79);
            width:750px;
            height:156px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        #info_div {
            margin: auto;
            background-color: rgba(10, 56, 75, 0.62);
            width: 512px;
            height:128px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding: 2px;
        }

        #info_table {
            background-color: rgba(255, 255, 255, 0.79);
            width:512px;
            height:128px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:2px;
        }

        .user {
            margin: auto;
            color: dodgerblue;
        }

        .main #static {
            width: 720px;
            height: 512px;
        }

        div #blk{
            background-color: rgba(195, 195, 195, 0.62);
            width:750px;
            height:485px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        table {
            margin: auto;
            /*border:0.25px solid rgba(10, 131, 169, 0.93);*/
        }

        form   {
            margin: auto;
            background-color: #d2d2d2;
            width:720px;
            height:545px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        #img_zone {
            margin-top: 0%;
            padding-top: 0%;
            vertical-align: top;
        }

        div #img_cont{
            margin-top: 0%%;
            padding-top: 0%;
            vertical-align: top;
        }

        .err {
            margin: auto;
            color: red;
            width: 256px;
            padding: 10px;
            font-size: larger;
            font-family: monospace;
        }

        <?php
        if(isset($error))
        {
            ?>
        input:focus
        {
            border: red 2px;
        }
        <?php
    }
    ?>


    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script language="JavaScript">
        var host = "http://localhost:80/SW/ProyectoSW-LB7";

        setInterval(function () {

            var mygetrequest;
            if(window.XMLHttpRequest)
                mygetrequest = XMLHttpRequest;
            else
                mygetrequest = ActiveXObject;
            mygetrequest.onreadystatechange=function(){
                if (mygetrequest.readyState===4){
                    if (mygetrequest.status===200 || window.location.href.indexOf("http")===-1){
                        $('#info_quantity').text(mygetrequest.responseText);
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            };

            var userId = $('#e-mail').val();
            mygetrequest.open("GET", host+"/.back-end/php/cantidad-preguntas.php?user="+userId, true);
            mygetrequest.send(null);

            $('#info_quantity').css('color','green');



            var result =  $('#info_users_editing');
            var counter;
            var xmlhttp;

            if(window.XMLHttpRequest)
                xmlhttp = XMLHttpRequest;
            else
                xmlhttp = ActiveXObject;
            result.css('color','red');
            xmlhttp.onreadystatechange = function () {
                result.css('color','orange');
                if(xmlhttp.readyState === 4 && xmlhttp.status === 200){
                    result.css('color','green');
                    if(xmlhttp.responseXML !== null){
                        counter = xmlhttp.responseXML.getElementsByTagName("contador").item(0);
                        result.text(counter.firstChild.nodeValue);
                    }
                }
            };
            xmlhttp.open("GET", host+'/.back-end/xml/contador.xml', true);
            xmlhttp.send();

        },20000);

        $(function() {

            setInterval(ajaxgetQuantityUserIn(), 5000);
            setInterval(ajaxgetQuantQuestions(), 20000);

            <?php  if($incr){
            ?>ajax_user_incr();<?php
            }
            ?>
        });

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

        function ajaxget(){
            var mygetrequest=new ajaxRequest();
            mygetrequest.onreadystatechange=function(){
                if (mygetrequest.readyState==4){
                    if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
                        document.getElementById("result").innerHTML = mygetrequest.responseText;
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            }
            var userId = encodeURIComponent(document.getElementById("e-mail").value);
            mygetrequest.open("GET", host+"/.back-end/php/ver-preguntas-ajax.php?user="+userId, true);
            mygetrequest.send(null);

            $('#blk').css('display','none');
            $('#feedback').css('display','none');
            $('#result').css('display','block');

        }

        function ajaxgetxml(){
            var mygetrequest=new ajaxRequest();
            mygetrequest.onreadystatechange=function(){
                if (mygetrequest.readyState==4){
                    if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
                        document.getElementById("result").innerHTML = mygetrequest.responseText;
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            }
            var userId = encodeURIComponent(document.getElementById("e-mail").value);
            mygetrequest.open("GET", host+"/.back-end/php/ver-preguntas-xml-ajax.php?user="+userId, true);
            mygetrequest.send(null);

            $('#blk').css('display','none');
            $('#feedback').css('display','none');
            $('#result').css('display','block');

        }

        function ajaxgetQuantQuestions(){
            var mygetrequest=new ajaxRequest();
            mygetrequest.onreadystatechange=function(){
                if (mygetrequest.readyState==4){
                    if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
                        $('#info_quantity').text(mygetrequest.responseText);
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            }

            var userId = $('#e-mail').val();
            mygetrequest.open("GET", host+"/.back-end/php/cantidad-preguntas.php?user="+userId, true);
            mygetrequest.send(null);

            $('#info_quantity').css('color','green');
        }

        function ajaxgetQuantityUserIn(){
            var result =  $('#info_users_editing');
            var counter;
            var xmlhttp=new ajaxRequest();
            result.css('color','red');
            xmlhttp.onreadystatechange = function () {
                result.css('color','orange');
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    result.css('color','green');
                    if(xmlhttp.responseXML !== null){
                        counter = xmlhttp.responseXML.getElementsByTagName("contador").item(0);
                        result.text(counter.firstChild.nodeValue);
                    }
                }
            }
            xmlhttp.open("GET", host+'/.back-end/xml/contador.xml', true);
            xmlhttp.send();
        }

        function ajax_user_incr(){
            var mygetrequest=new ajaxRequest();
            mygetrequest.onreadystatechange=function(){
                if (mygetrequest.readyState==4){
                    if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
                        $('#info_users_editing').text(mygetrequest.responseText);
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            }
            var userId = $('#e-mail').val();
            mygetrequest.open("GET", host+"/.back-end/php/cantidad-visitantes-dentro.php?user="+userId, true);
            mygetrequest.send();
            result.css('color','blue');
        }

        function ajaxpost(){
            var mypostrequest=new ajaxRequest();
            mypostrequest.onreadystatechange=function(){
                if (mypostrequest.readyState===4){
                    if (mypostrequest.status===200 || window.location.href.indexOf("http")===-1){
                        document.getElementById("feedback").innerHTML = mypostrequest.responseText;
                    }
                    else{
                        alert("An error has occured making the request");
                    }
                }
            }

            var userId = encodeURIComponent(document.getElementById("e-mail").value);
            var nivel = encodeURIComponent(document.getElementById("lvl").value);
            var tema = encodeURIComponent(document.getElementById("tm").value);
            var pregunta = encodeURIComponent(document.getElementById("Qst").value);
            var respuesta = encodeURIComponent(document.getElementById("ans").value);
            var incorrecta1 = encodeURIComponent(document.getElementById("noAns1").value);
            var incorrecta2 = encodeURIComponent(document.getElementById("noAns2").value);
            var incorrecta3 = encodeURIComponent(document.getElementById("noAns3").value);
            var parameters="email="+userId+"&level="+nivel+"&tema="+tema+"&question="+pregunta+"&correctAns="+respuesta+"&incorrectAns1="+incorrecta1+"&incorrectAns2="+incorrecta2+"&incorrectAns3="+incorrecta3;
            mypostrequest.open("POST", host+"/.back-end/php/insertar-preguntas-ajax.php", true);
            mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            mypostrequest.send(parameters);

            $('#feedback').css('display','block');

        }

        function mostrarFormulario() {
            $('#result').css('display','none');
            $('#feedback').css('display','none');
            $('#blk').css('display','block');

        }





    </script>
</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <div id='ident' align="center">
            <table id="t_iden" width="64px">
                <tr>
                    <td>
                        <p align='center' class='user'><?php echo $email?></p>
                    </td>
                    <td id='td_img' height="64px">
                        <?php echo '<img id="u_img" height="128px" src="data:image/type;base64,'.base64_encode( $row['imagen']).' "/>'?>
                    </td>
                </tr>
            </table>
        </div>
        <span class="right"><a onclick="alert('Cierre de sesion')" href="../../../.back-end/php/logout.php">Logout</a></span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <div style="height: auto;">
    <nav class='main' id='n1' role='navigation'>
        <span><a href='layout.php'>Inicio</a></span>
        <span><a href='creditos.php'>Creditos</a></span>
    </nav>
    <section class="main" id="s1">
        <div id='info_div' align="center">
            <table id='info_table' align="center">
                <tr>
                    <td>
                        <div align="center">Cantidad preguntas tuyas / Total preguntas :<div id="info_quantity">i/N</div></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div align="center">Usuarios editando preguntas:<div id="info_users_editing">i</div></div>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
            <td>
         <span><button value="Insertar Pregunta" style="background-color: lightgreen" onclick="mostrarFormulario()">Insertar Pregunta</button></span>
                <span><button value="Ver preguntas" style="background-color: lightgreen"  onclick="ajaxget()">ver preguntas de la BD</button></span>
                <span><button value="Ver preguntas xml" style="background-color: lightgreen"  onclick="ajaxgetxml()">ver preguntas XML</button></span>
            </td>
            </tr>
        </table>
        <table id="static" width="720px">
            <tr>

                <td>
        <div align="right">
            <div id="blk" align="left">
                </br>
                <table >
                    <form id='fpreguntas' name='fpreguntas' action="../../../.back-end/php/insertar-preguntas-ajax.php" method="Post" enctype="multipart/form-data">
                        <tr>

                            <td>

                                Email*: &nbsp;</br><input type="text" disabled size="50"  id="e-mail" name="email" placeholder="p.e. alumno@ikasle.ehu.eus" value="<?php if(isset($email)){echo $email;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></br>
                                Dificultad de la pregunta*: &nbsp;</br><input type="text" size="50" id="lvl" name="level" placeholder="p.e. 4:" value ="<?php if(isset($level)){echo $level;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?>/></br>
                                Tema*: &nbsp;</br><input type="text" size="50" id="tm" name="tema" placeholder="p.e. Matematicas" value="<?php if(isset($tema)){echo $tema;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?>/></br>
                                Enunciado de la pregunta*: &nbsp;</br><input type="text" size="50" id="Qst" name="question" placeholder="p.e. Descubrio las propiedades de los fractales:" value="<?php if(isset($question)){echo $question;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?>/></br>
                                Repuesta correcta*: &nbsp;</br><input type="text" size="50" id="ans" name="correctAns" placeholder="p.e. Nikola Tesla" value="<?php if(isset($correctAns)){echo $correctAns;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?>/></br>
                                Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns1" name="incorrectAns1" placeholder="p.e. Benoît Mandelbrot" value="<?php if(isset($incorrectAns1)){echo $incorrectAns1;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?>/></br>
                                Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns2" name="incorrectAns2" placeholder="p.e. Homer Simpson" value="<?php if(isset($incorrectAns2)){echo $incorrectAns2;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?>/></br>
                                Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns3" name="incorrectAns3" placeholder="p.e. Thomas Edison" value="<?php if(isset($incorrectAns3)){echo $incorrectAns3;} ?>"  <?php if(isset($code) && $code == 8){ echo "autofocus"; }  ?>/></br></br>
                                <input type="button" id="submiter" name="submiter" value="Enviar" align="center" onclick="return ajaxpost(this)">&nbsp;
                                <input type=reset id="rst" value="Clear Form"></br></br>
                            </td>
                            <td id="img_zone" align="top">
                                <div id="img_cont" align="center">
                                    <input id="file_url" type="file" id="img" name="image" align="right"></br>
                                    <div align="center">
                                        <img id="img_destino" src="../resources/img/default.jpg" alt="Tu imagen" align="center" width="256px">
                                    </div>
                                </div>
                            </td>
                    </form>
                    </tr>
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
                </table>
            </div>
        </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="result"></div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <div id="feedback"></div>
                </td>
            </tr>
        </table>
    </section>
    </div>
    <footer class='main' id='f1'>
        <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
        <a href='https://github.com/swg27/'>Link GITHUB</a>
    </footer>
</div>

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