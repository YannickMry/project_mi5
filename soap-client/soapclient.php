<?php

namespace SoapClient;

use SoapClient\Commande;

require_once("./Commande.php");

ini_set("soap.wsdl_cache_enabled", "0");
$options=array('trace'=>1, 'encoding'=>'UTF-8', 'soap_version'=>SOAP_1_2, 'classmap' => ['CommandeSoap' => "\SoapClient\Commande"]);
try {
    $soapClient = new \SoapClient('http://localhost:8000/soap?wsdl', $options);
} catch (SoapFault $e) {
    var_dump($e);
}

try {
    $functions = $soapClient->__getFunctions();
    var_dump ($functions);
    $result = $soapClient->__soapcall("sayHello", array("John"));
    echo '<p>'.$result.'</p>';
    $result = $soapClient->__soapcall("sumHello", array(2,5));
    echo '<p>'.$result.'</p>';


    $command = $soapClient->__soapcall("getLastCommandForUserId", [5]);

    echo '<p> id de la dernière commande : '.$command->getId().'</p>';
    echo '<p> status de la dernière commande : '.$command->getStatus().'</p>';
    echo '<p> date de la dernière commande : '. $command->getCreatedAt() .'</p>';

    $rawResult = $soapClient->__getLastResponse();

    echo '<br>';

} catch(SoapFault $fault){
    // <xmp> tag displays xml output in html
    echo 'Request : <br/><xmp>',
    $soapClient->__getLastRequest(),
    '</xmp><br/><br/> Error Message : <br/>',
    $fault->getMessage();
    $fault->getTraceAsString();
}
?>