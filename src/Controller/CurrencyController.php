<?php

namespace App\Controller;

use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/synchronize", name="synchronize")
     */
    public function synchronize(): Response
    {
        $xmlString = file_get_contents("http://api.nbp.pl/api/exchangerates/tables/A/?format=xml");
        $xml = new SimpleXMLElement($xmlString);


        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
            var_dump($xml)
        ]);
    }
    /**
     * @Route("/currency", name="currency")
     */
    public function display(): Response
    {
        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }

}
