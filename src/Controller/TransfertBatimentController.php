<?php

namespace App\Controller;

use App\Entity\TransfertBatiment;
use App\Form\TransfertBatimentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TransfertBatimentController extends AbstractController
{
    #[Route('/gestionnaire/transfert/batiment/{id}', name: 'app_transfert_batiment')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $tralfertbatiment = new TransfertBatiment();

        $form = $this->createForm(TransfertBatimentType::class, $tralfertbatiment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $tralfertbatiment->setUser($this->getUser());

            $em->persist($tralfertbatiment);
            $em->flush();

            return $this->redirectToRoute("app_transfert_batiment_list");

        }
        return $this->render('transfert_batiment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/transfert/batiment/bande/list', name: 'app_transfert_batiment_list_bande')]
    public function list(EntityManagerInterface $em): Response
    {
        $tralfertbatiment = $em->getRepository(TransfertBatiment::class)->findAll();
        // dd($tralfertbatiment);
        return $this->render('transfert_batiment/list.html.twig', [
            'transferts' => $tralfertbatiment,
        ]);
    }
}
