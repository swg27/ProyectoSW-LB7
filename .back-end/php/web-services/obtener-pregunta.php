<?php
require_once('../../../nusoap/src/nusoap.php');
//require_once ('../../../../../lib/nusoap-0.9.5/lib/nusoap.php');
//require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdlcache.php');

$ns = "localhost:80/lib/nusoap-0.9.5/samples";

$server = new soap_server;

$server->configureWSDL('verifyPassword', $ns);

$server->wsdl->schemaTargetNamespace=$ns;

$server->register('obtenerPregunta',
    array('cod_pregunta'=>'xsd:string'),
    array('pregunta'=>'xsd:string', 'respuesta'=>'xsd:string','complejidad'=>'xsd:int'),
    $ns);




function takeQuery($cod_pregunta){

    include_once '../../.others/.Dbconnect.php';

$sql = "SELECT pregunta, respuesta, dificultad FROM preguntas WHERE cod_pregunta=$cod_pregunta";

if (!mysqli_query($conn, $sql)) {
    echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
    die('Error: ' . mysqli_error($conn));
}
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);

$pregunta = $row['pregunta'];
$respuesta = $row['respuesta'];
$complejidad = $row['dificultad'];

return $pregunta + $respuesta + $complejidad;

    $sql->close();
    mysqli_close($conn);

}


if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?>