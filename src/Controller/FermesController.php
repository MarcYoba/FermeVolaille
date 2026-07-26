<?php

namespace App\Controller;

use App\Entity\Fermes;
use App\Form\FermesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FermesController extends AbstractController
{
    #[Route('/admin/fermes', name: 'app_fermes')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $fermes = new Fermes();
        $form = $this->createForm(FermesType::class, $fermes);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $fermes->setUser($this->getUser());
            $em->persist($fermes);
            $em->flush();

            return $this->redirectToRoute('app_fremes_list');

        }

        return $this->render('fermes/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/fermes/list', name: "app_fremes_list")]
    public function list(EntityManagerInterface $em) : Response 
    {
        $fermes = $em->getRepository(Fermes::class)->findAll();  
        
        return $this->render('fermes/list.html.twig', [
            'fermes' => $fermes,
        ]);
    }

    #[Route('/admin/fermes/edit/{id}', name: "app_fremes_edit")]
    public function edit(EntityManagerInterface $em, Request $request, int $id) : Response 
    {
        $fermes = $em->getRepository(Fermes::class)->find($id); 
        if (!$fermes) {
            return $this->redirectToRoute('app_fermes_list');
        }
        
        $form = $this->createForm(FermesType::class, $fermes);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $fermes->setUser($this->getUser());
            $em->persist($fermes);
            $em->flush();

            return $this->redirectToRoute('app_fremes_list');

        }

        return $this->render('fermes/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/fermes/delete/{id}', name:'app_fermes_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
       $fermes = $em->getRepository(Fermes::class)->find($id); 
        if (!$fermes) {
            return $this->redirectToRoute('app_fremes_list');
        }
        $em->remove($fermes);
        $em->flush();
        
        return $this->redirectToRoute('app_fremes_list');
    }
}
