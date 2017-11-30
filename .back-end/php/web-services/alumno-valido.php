<?php

if(isset($_POST['email'])){

    require_once('../../../nusoap/src/nusoap.php');

//require_once('../../../../..//lib/nusoap-0.9.5/lib/nusoap.php');
//require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdlcache.php');

$user = addslashes(htmlspecialchars($_POST['email']));
$ns = "http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl";
$soapclient = new nusoap_client($ns, true);

$result = $soapclient->call('comprobar', array('x' => $user));

echo $result;
}

?>


