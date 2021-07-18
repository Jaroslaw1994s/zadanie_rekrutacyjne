<?php

namespace App\Controller;

use App\Entity\Currency;
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
        $rates = $xml->ExchangeRatesTable[0]->Rates[0]->Rate;

        foreach($rates as $rate)
        {
            $name = $rate->Currency;
            $currencyCode = $rate->Code;
            $exchangeRateFloat = $rate->Mid;
            $exchangeRate = (float)$exchangeRateFloat*10000;
            $CurrencySYNC = new Currency($name, $currencyCode, $exchangeRate);
        }


        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
            var_dump($CurrencySYNC)
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
