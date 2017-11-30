<?php

if(isset($_POST['contrasenha'])){
    require_once('../../../nusoap/src/nusoap.php');
    //require_once('../../../../..//lib/nusoap-0.9.5/lib/nusoap.php');
    //require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdlcache.php');

    include_once ('../../.others/vars.php');

    $pass = addslashes(htmlspecialchars(trim($_POST['contrasenha'])));
    $ns= "$host/.back-end/php/web-services/comprobar-contrasena.php?wsdl";
    $soapclient = new nusoap_client($ns, true);

    $passIsValid = $soapclient->call('verifyPassword', array('pass' => $pass));

    if(trim($passIsValid) === 'VALIDA'){
        echo 'true';
    }else if(trim($passIsValid) === 'INVALIDA'){
        echo 'false';
    }

}

?>