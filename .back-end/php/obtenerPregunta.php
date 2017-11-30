<!DOCTYPE html>
<html>
<?php

include_once 'seguridad.php';

if(isset($_SESSION['ID'])){

    include_once '../.others/.Dbconnect.php';

    $cod_pregunta = $_GET['cod_pregunta'];

    $query = "SELECT * FROM Preguntas WHERE CodPregunta=$cod_pregunta";
    $QueryPregunta = mysqli_query($conn, $query) or die ('Error : '.mysqli_error($conn));

    $row = mysqli_fetch_array($QueryPregunta);

}

$result .= '<div id="blk" align="left">
    </br>
    <table >
        <form id="fpreguntas" name="fpreguntas" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"  method="Post" enctype="multipart/form-data">
            <tr>

                <td>

                    Email*: &nbsp;</br><input type="text" disabled size="50"  id="e-mail" name="email" placeholder="'.$row["email"].'" value="'.$row["email"].'" /></br>
                    Dificultad de la pregunta*: &nbsp;</br><input type="text" size="50" id="lvl" name="level" placeholder="'.$row["dificultad"].'" value ="'.$row["dificultad"].'"/></br>
                    Tema*: &nbsp;</br><input type="text" size="50" id="tm" name="tema" placeholder="'.$row["tema"].'" value="'.$row["tema"].'"/></br>
                    Enunciado de la pregunta*: &nbsp;</br><input type="text" size="50" id="Qst" name="question" placeholder="'.$row["pregunta"].'" value="'.$row["pregunta"].'"/></br>
                    Repuesta correcta*: &nbsp;</br><input type="text" size="50" id="ans" name="correctAns" placeholder="'.$row["respuesta"].'" value="'.$row["respuesta"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns1" name="incorrectAns1" placeholder="'.$row["no_respuesta_1"].'" value="'.$row["no_respuesta_1"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns2" name="incorrectAns2" placeholder="'.$row["no_respuesta_2"].'" value="'.$row["no_respuesta_2"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns3" name="incorrectAns3" placeholder="'.$row["no_respuesta_3"].'" value="'.$row["no_respuesta_3"].'"/></br></br>
                    <input type="button" id="submiter" name="submiter" value="Enviar" align="center" onclick="ajaxPost()">&nbsp;
                    <input type=reset id="rst" value="Clear Form"></br></br>
                </td>
        </form>
        </tr>
    </table>
</div>';


echo $result;

?>
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
        var cod_pregunta = encodeURIComponent(<?php echo $cod_pregunta; ?>);
        var userId = encodeURIComponent(document.getElementById("e-mail").value);
        var nivel = encodeURIComponent(document.getElementById("lvl").value);
        var tema = encodeURIComponent(document.getElementById("tm").value);
        var pregunta = encodeURIComponent(document.getElementById("Qst").value);
        var respuesta = encodeURIComponent(document.getElementById("ans").value);
        var incorrecta1 = encodeURIComponent(document.getElementById("noAns1").value);
        var incorrecta2 = encodeURIComponent(document.getElementById("noAns2").value);
        var incorrecta3 = encodeURIComponent(document.getElementById("noAns3").value);
        var parameters="cod_pregunta="+cod_pregunta+"$email="+userId+"&level="+nivel+"&tema="+tema+"&question="+pregunta+"&correctAns="+respuesta+"&incorrectAns1="+incorrecta1+"&incorrectAns2="+incorrecta2+"&incorrectAns3="+incorrecta3;
        mypostrequest.open("POST", "http://localhost:80/SW/ProyectoSW-LB7/.back-end/php/actualizarPregunta.php", true);
        mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        mypostrequest.send(parameters);

        console.log('TRACE N: ajaxPost()');


    }
</script>
</html>
