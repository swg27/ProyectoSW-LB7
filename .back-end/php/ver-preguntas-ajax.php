<!DOCTYPE html>
<html>
<style>
   #mysql_table {
        margin: auto;
        padding: 1%;
        border: 2px;
        border-bottom-color: dodgerblue;
        background-color: rgba(10, 56, 75, 0.53);
    }
    #mysql_table tr{
        margin: auto;
        padding: 0%;
        border: 2px;
        border-bottom-color: dodgerblue;
        background-color: rgb(255, 253, 219);
    }

    #mysql_table td p {
        margin-left: 2%;
        margin-right: 5%;
        margin-top: 3%;
        margin-bottom: 1%;
    }

</style>
<?php

if(isset($_GET['user']))
{
    $email = $_GET['user'];
    if (empty($email)) {
        echo 'error 1';
    } else if (!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email)) {
        echo 'error 2';
    } else {

        include_once '../.others/.Dbconnect.php';

        $error = false;

        $sql = "SELECT email FROM users WHERE email='$email'";

        if (!mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
            die('Error: ' . mysqli_error($conn));
        }else{

            $user = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($user);

            clearstatcache();

            if($email == $row['email']) {

                $error=false;

                $preguntas=mysqli_query($conn, "SELECT * FROM preguntas");


                $resultado .= '<table id="mysql_table" cellspacing="0" cellpadding="0" border="0" width="512px">
                  <tr>
                    <td>   
                        <table cellspacing="15%" cellpadding="0" border="1" width="512px" >
                            <tr style="color:white;background-color:darkcyan">
                                <th><span class="text">CodPregunta</span></th> 
                                <th><span class="text">Dificultad</span></th>  
                                <th><span class="text">Tema</span></th> 
                                <th><span class="text">Pregunta</span></th> 
                                <th><span class="text">Respuesta</span></th> reguntas
                                <th><span class="text">Incorrecta</span></th> 
                                <th><span class="text">Incorrecta</span></th> 
                                <th><span class="text">Incorrecta</span></th>
                                <th><span class="text">email</span></th>
                                <th><span class="text">Imagen</span></th>
                            </tr>
                        </table>
                    </td>
                  </tr>
                    <tr>
                      <td>
                        <div style="width:1024px; height:512px; overflow:auto;">
                         <table cellspacing="2%" cellpadding="1" border="1" width="512px" >
                                
                                <tr style="color:white;background-color:darkcyan">
                                <th><span class="text">CodPregunta</span></th> 
                                <th><span class="text">Dificultad</span></th>  
                                <th><span class="text">Tema</span></th> 
                                <th><span class="text">Pregunta</span></th> 
                                <th><span class="text">Respuesta</span></th> 
                                <th><span class="text">Incorrecta</span></th> 
                                <th><span class="text">Incorrecta</span></th> 
                                <th><span class="text">Incorrecta</span></th>
                                <th><span class="text">email</span></th>
                                <th><span class="text">Imagen</span></th>
                            </tr>';
                             while($row = mysqli_fetch_array($preguntas)){

                                 $resultado .= '
                               <tr>
                                <td align="center">'.$row['cod_pregunta'].'</td>
                                <td align="center">'.$row['dificultad'].'</td>
                                <td align="center">'.$row['tema'].'</td>
                                <td align="center">'.$row['pregunta'].'</td>
                                <td align="center">'.$row['respuesta'].'</td>
                                <td align="center">'.$row['no_respuesta_1'].'</td>
                                <td align="center">'.$row['no_respuesta_2'].'</td>
                                <td align="center">'.$row['no_respuesta_3'].'</td>
                                <td align="center">'.$row['email'].'</td>
                                <td align="center">'
                                     .'<img src="data:image/type;base64,'.base64_encode( $row['image']).'"/>'.
                                     '    
                                </td>
                              </tr>';
                             }

                $resultado .= '
                </table>  
                        </div>
                      </td>
                    </tr>
                </table>';

                echo $resultado;
                $preguntas->close();
                mysqli_close($conn);

                ?>

                <?php
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

</html>

