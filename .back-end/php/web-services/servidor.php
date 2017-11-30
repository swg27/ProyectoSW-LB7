<?php

require_once ('../../../../../lib/nusoap-0.9.5/lib/nusoap.php');
require_once ('../../../../../lib/nusoap-0.9.5/lib/class.wsdl.php');

$ns="http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl";

$server = new soap_server;

$server->configureWSDL('comprobar', $ns);

$server->wsdl->schemaTargetNamespace=$ns;

$server->register('comprobar',
    array('x'=>'xsd:string'));

?>