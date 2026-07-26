<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProduitController extends AbstractController
{
    #[Route('/gestionnaire/produit/create', name: 'app_produit')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $produit->setUser($this->getUser());

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('app_produit_list');
        }
        return $this->render('produit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/produit/liste', name: 'app_produit_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $produit = $em->getRepository(Produit::class)->findAll();

        return $this->render('produit/list.html.twig', [
            'produits' => $produit,
        ]);
    }

    #[Route('/gestionnaire/produit/edit/{id}', name: 'app_produit_edit')]
    public function edit(EntityManagerInterface $em, Request $request, int $id) : Response 
    {
        $produit = $em->getRepository(Produit::class)->find($id);
        if (!$produit) {
            return $this->redirectToRoute('app_produit_list');
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $produit->setUser($this->getUser());

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('app_produit_list');
        }
        return $this->render('produit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/produit/delete/{id}', 'app_produit_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
       $produit = $em->getRepository(Produit::class)->find($id);
        if (!$produit) {
            return $this->redirectToRoute('app_produit_list');
        }
        
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute('app_produit_list');
    }

}
