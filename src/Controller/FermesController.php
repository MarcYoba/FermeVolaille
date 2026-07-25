<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FermesController extends AbstractController
{
    #[Route('/gestionnaire/fermes', name: 'app_fermes')]
    public function index(): Response
    {
        return $this->render('fermes/index.html.twig', [
            'controller_name' => 'FermesController',
        ]);
    }
}
