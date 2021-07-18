<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/currency", name="currency")
     */
    public function index(): Response
    {
        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }
}
