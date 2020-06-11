<?php

namespace App\Controller\Soap;

use App\Soap\SoapOp;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoapController extends AbstractController
{
	/**
     * @Route("/soap", name="soap")
     */
    public function soapAction()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $options= array(
            'trace'=>1,
            'encoding'  => 'UTF-8',
            'uri' => 'http://localhost:8000/soap',
            'exceptions' => true,
        );

		$soapServer = new \SoapServer("../soap.wsdl",$options);
		$soapServer->setObject(new SoapOp($this->getDoctrine()->getManager()));
		$response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
	}
}
?>