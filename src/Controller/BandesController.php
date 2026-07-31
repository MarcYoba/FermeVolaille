<?php

namespace App\Controller;

use App\Entity\Bandes;
use App\Entity\Fermes;
use App\Form\BandesType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BandesController extends AbstractController
{
    #[Route('/gestionnaire/bandes/create', name: 'app_bandes')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $bande = new Bandes();
        $form = $this->createForm(BandesType::class,$bande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $fermes = $em->getRepository(Fermes::class)->find(1);
            $bande->setFerme($fermes);
            $bande->setUser($this->getUser());
            $bande->setCreatetAt(new \DateTime());
            $bande->setStatus("EN COUR");

            $em->persist($bande);
            $em->flush();

            return $this->redirectToRoute('app_bandes_liste');
        }
        return $this->render('bandes/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/bandes/list', name: 'app_bandes_liste')]
    public function list(EntityManagerInterface $em): Response
    {
        $bandes = $em->getRepository(Bandes::class)->findAll();

        return $this->render('bandes/list.html.twig', [
            'bandes' => $bandes,
        ]);
    }

    #[Route('/admin/bandes/edit/{id}', name: 'app_bandes_edit')]
    public function edit(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $bande = $em->getRepository(Bandes::class)->find($id);

        if (!$bande) {
            return $this->redirectToRoute('app_bandes_liste');
        }

        $form = $this->createForm(BandesType::class,$bande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $fermes = $em->getRepository(Fermes::class)->find(1);
            $bande->setFerme($fermes);
            $bande->setUser($this->getUser());
            $bande->setCreatetAt(new \DateTime());
            $bande->setStatus("EN COUR");

            return $this->redirectToRoute('app_bandes_liste');
        }
        return $this->render('bandes/index.html.twig', [
            'bandes' => $bande,
        ]);
    }

    #[Route('/admin/bandes/delete/{id}', name: 'app_bandes_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
       $bande = $em->getRepository(Bandes::class)->find($id);

        if (!$bande) {
            return $this->redirectToRoute('app_bandes_liste');
        }
        
        $em->remove($bande);
        $em->flush();

        return $this->redirectToRoute('app_bandes_liste');
    }
}
