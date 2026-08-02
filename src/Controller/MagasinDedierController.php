<?php

namespace App\Controller;

use App\Entity\MagasinDedier;
use App\Form\MagasinDedierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MagasinDedierController extends AbstractController
{
    #[Route('/getionnaire/magasin/dedier', name: 'app_magasin_dedier')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $magasindedier = new MagasinDedier();
        $form = $this->createForm(MagasinDedierType::class,$magasindedier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $magasindedier->setUser($this->getUser());

            $em->persist($magasindedier);
            $em->flush();

            return $this->redirectToRoute('app_magasin_dedier_list');
        }
        return $this->render('magasin_dedier/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/getstionnaire/magasin/dedier/list', name:'app_magasin_dedier_list')]
    public function list(EntityManagerInterface $em) : Response 
    {
        $magasindedier = $em->getRepository(MagasinDedier::class)->findAll();

        return $this->render('magasin_dedier/index.html.twig', [
            'magasindediers' => $magasindedier,
        ]);
    }
}
