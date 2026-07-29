<?php

namespace App\Controller;

use App\Entity\Magasin;
use App\Entity\Produit;
use App\Form\MagasinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MagasinController extends AbstractController
{
    #[Route('/admin/magasin/create', name: 'app_magasin')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $magasin = new Magasin();
        $form = $this->createForm(MagasinType::class,$magasin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->get('produit')->getData();
            $quantite = $form->get('quantite')->getData();
            $produitexit = $em->getRepository(Magasin::class)->find($produit->getId());
            $magasin->setUser($this->getUser());

            if ($produitexit) {
                $qt = $produitexit->getQuantite();
                $produitexit->setQuantite( $qt + $quantite) ;
                $em->persist($produitexit);
            }else{
                $em->persist($magasin);
            }

            $em->flush();

            return $this->redirectToRoute('app_magasin_list');
        }
        return $this->render('magasin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/magasin/list', name: 'app_magasin_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $magasin = $em->getRepository(Magasin::class)->findAll();

        return $this->render('magasin/list.html.twig', [
            'magasins' => $magasin,
        ]);
    }

    #[Route('/admin/magasin/edit/{id}', name: 'app_magasin_edit')]
    public function edit(EntityManagerInterface $em,Request $request,int $id): Response
    {
        $magasin = $em->getRepository(Magasin::class)->find($id);
        if(!$magasin)
        {
            return $this->redirectToRoute('app_magasin_list');
        }

        $form = $this->createForm(MagasinType::class,$magasin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $magasin->setUser($this->getUser());

            
                $em->persist($magasin);
            

            $em->flush();

            return $this->redirectToRoute('app_magasin_list');
        }
        return $this->render('magasin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/magasin/delete/{id}', name: 'app_magasin_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $magasin = $em->getRepository(Magasin::class)->find($id);
        if(!$magasin)
        {
            return $this->redirectToRoute('app_magasin_list');
        }

        $em->remove($magasin);
        $em->flush();

        return $this->redirectToRoute('app_magasin_list');
    }
}
