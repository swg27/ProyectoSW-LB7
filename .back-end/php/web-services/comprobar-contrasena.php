<?php

require_once('../../../nusoap/src/nusoap.php');

//require_once ('../../../../../lib/nusoap-0.9.5/lib/nusoap.php');
//require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdlcache.php');

include_once ('../../.others/vars.php');

$ns = "$host/.back-end/php/web-services/comprobar-contrasena.php";

$server = new soap_server;

$server->configureWSDL('verifyPassword', $ns);

$server->wsdl->schemaTargetNamespace=$ns;

$server->register('verifyPassword',
    array('pass'=>'xsd:string'),
    array('r'=>'xsd:string'),
    $ns);

function verifyPassword($pass){
$file_path = '../../../front-end/.Users/resources/txt/toppasswords.txt';
$myfile = fopen($file_path, "r") or die("Unable to open file!");
$r = 'VALIDA';
while ($line = fgets($myfile)) {
    //echo "[ $line ]";
    if(trim($line) === trim($pass)){
        if (stripos(trim($line), trim($pass)) !== false) {
            //echo " eres un usuario valido pero la contrasenha: $pass esta contenida como invalida";
            $r = 'INVALIDA';
            break;
        }
        $r = 'INVALIDA';
        break;
    }
}
return $r;
//echo fread($myfile,filesize($file_path));
fclose($myfile);
}

if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?>

