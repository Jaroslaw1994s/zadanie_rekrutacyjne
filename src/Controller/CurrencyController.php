<?php

namespace App\Controller;

use App\Entity\Currency;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/synchronize", name="synchronize")
     */
    public function synchronize(EntityManagerInterface $em): Response
    {
        $xmlString = file_get_contents("http://api.nbp.pl/api/exchangerates/tables/A/?format=xml");
        $xml = new SimpleXMLElement($xmlString);
        $rates = $xml->ExchangeRatesTable[0]->Rates[0]->Rate;
        $repository = $em->getRepository(Currency::class);
        $currencyAll = $repository->findAll();
        $entityManager = $this->getDoctrine()->getManager();

        foreach($rates as $rate)
        {
            $name = $rate->Currency;
            $currencyCode = $rate->Code;
            $exchangeRateFloat = $rate->Mid;
            $exchangeRate = (float)$exchangeRateFloat*10000;

            $CurrencySYNC = new Currency($name, $currencyCode, $exchangeRate);
            $isUpdated = FALSE;

            foreach($currencyAll as $currency)
            {
                if($currency->getCurrencyCode() == $currencyCode)
                {
                    $currency->setExchangeRate($exchangeRate);
                    $entityManager->persist($currency);
                    $entityManager->flush();
                    $isUpdated = TRUE;
                }
            }
        }


        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }
    /**
     * @Route("/currency", name="currency")
     */
    public function display(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Currency::class);
        $currencyAll = $repository->findAll();
        $entityManager = $this->getDoctrine()->getManager();

        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }

}
