<!DOCTYPE html>
<html>
<?php

include_once 'seguridad.php';

if(isset($_SESSION['ID'])){

    $email = trim($_POST['email']);

    $level = trim($_POST['level']);
    $tema = trim($_POST['tema']);
    $question = trim($_POST['question']);
    $correctAns = trim($_POST['correctAns']);
    $incorrectAns1 = trim($_POST['incorrectAns1']);
    $incorrectAns2 = trim($_POST['incorrectAns2']);
    $incorrectAns3 = trim($_POST['incorrectAns3']);



    include_once '../.others/.Dbconnect.php';

    $cod_pregunta = $_POST['cod_pregunta'];
    echo $cod_pregunta;

    $QueryPregunta = "UPDATE preguntas SET dificultad=$level, tema='$tema', pregunta='$question', respuesta='$correctAns', no_respuesta_1='$incorrectAns1', no_respuesta_2='$incorrectAns2', no_respuesta_3='$incorrectAns3' WHERE cod_pregunta=$cod_pregunta";

    if (!mysqli_query($conn, $QueryPregunta)) {
        die('Error: ' . mysqli_error($conn));
    }else{

    $Query = mysqli_query($conn, $QueryPregunta);

    $row3 = mysqli_fetch_array($Query);


}


$result .= '<div id="blk" align="left">
    </br>
    <table >
        <form id="fpreguntas" name="fpreguntas" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="Post" enctype="multipart/form-data">
            <tr>

                <td>

                    Email*: &nbsp;</br><input type="text" disabled size="50"  id="e-mail" name="email" placeholder="'.$row3["email"].'" value="'.$row3["email"].'" /></br>
                    Dificultad de la pregunta*: &nbsp;</br><input type="text" size="50" id="lvl" name="level" placeholder="'.$row3["dificultad"].'" value ="'.$row["dificultad"].'"/></br>
                    Tema*: &nbsp;</br><input type="text" size="50" id="tm" name="tema" placeholder="'.$row3["tema"].'" value="'.$row["tema"].'"/></br>
                    Enunciado de la pregunta*: &nbsp;</br><input type="text" size="50" id="Qst" name="question" placeholder="'.$row3["pregunta"].'" value="'.$row3["pregunta"].'"/></br>
                    Repuesta correcta*: &nbsp;</br><input type="text" size="50" id="ans" name="correctAns" placeholder="'.$row3["respuesta"].'" value="'.$row3["respuesta"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns1" name="incorrectAns1" placeholder="'.$row3["no_respuesta_1"].'" value="'.$row3["no_respuesta_1"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns2" name="incorrectAns2" placeholder="'.$row3["no_respuesta_2"].'" value="'.$row3["no_respuesta_2"].'"/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns3" name="incorrectAns3" placeholder="'.$row3["no_respuesta_3"].'" value="'.$row3["no_respuesta_3"].'"/></br></br>
                    <input type="button" id="submiter" name="submiter" value="Enviar" align="center" onclick="">&nbsp;
                    <input type=reset id="rst" value="Clear Form"></br></br>
                </td>
        </form>
        </tr>
    </table>
</div>';


echo $result;
}
?>

</html>
