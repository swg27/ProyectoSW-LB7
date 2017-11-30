<!DOCTYPE html>
<?php
$xslDoc = new DOMDocument();
$xslDoc->load("../.others/ver-preguntas.xsl");
$xmlDoc = new DOMDocument();
$xmlDoc->load("../xml/questions.xml");
$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);
?>

