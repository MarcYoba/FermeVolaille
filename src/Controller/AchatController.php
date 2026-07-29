<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Magasin;
use App\Form\AchatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AchatController extends AbstractController
{
    #[Route('/gestionnaire/achat', name: 'app_achat')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->get('produit')->getData();
            $qt = $form->get('quantite')->getData();

            $magasin = $em->getRepository(Magasin::class)->findOneBy(['produit' => $produit->getID()]);
            
            if($magasin){
                $quantite = $magasin->getQuantite();

                $magasin->setQuantite($quantite+$qt);
                $em->persist($magasin);
            }else {
                $magasin = new Magasin();

                $magasin->getProduit($produit);
                $magasin->setQuantite($qt);
                $magasin->setUser($this->getUser());
                $magasin->setCreatetAt(new \DateTime());

                $em->persist($magasin);
            }
            $achat->setUser($this->getUser());
            $em->persist($achat);
            $em->flush();

            return $this->redirectToRoute('app_achat_list');
        }
        return $this->render('achat/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/achat/list', name: 'app_achat_list')]
    public function list(EntityManagerInterface $em) : Response 
    {
        $achats = $em->getRepository(Achat::class)->findAll();

        return $this->render('achat/list.html.twig', [
            'achats' => $achats,
        ]);
    }

    #[Route('/admin/achat/edit/{id}', name: 'app_achat_edit')]
    public function edit(EntityManagerInterface $em,Request $request,int $id) : Response 
    {
        $achat = $em->getRepository(Achat::class)->find($id);
        if (!$achat) {
            return $this->redirectToRoute('app_achat_list');
        }

        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $achat->setUser($this->getUser());
            $em->persist($achat);
            $em->flush();

            return $this->redirectToRoute('');
        }
        return $this->render('achat/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/achat/delete/{id}', name: 'app_achat_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
        $achat = $em->getRepository(Achat::class)->find($id);
        if (!$achat) {
            return $this->redirectToRoute('app_achat_list');
        }

        $em->persist($achat);
        $em->flush();

        return $this->redirectToRoute('app_achat_list');
    }
}
