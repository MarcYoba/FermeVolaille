<?php

namespace App\Controller;

use App\Entity\Inventaire;
use App\Form\InventaireType;
use App\Repository\InventaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/gestionaire/inventaire')]
final class InventaireController extends AbstractController
{
    #[Route('list',name: 'app_inventaire_index', methods: ['GET'])]
    public function index(InventaireRepository $inventaireRepository): Response
    {
        return $this->render('inventaire/index.html.twig', [
            'inventaires' => $inventaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inventaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inventaire = new Inventaire();
        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inventaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_inventaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inventaire/new.html.twig', [
            'inventaire' => $inventaire,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/detail', name: 'app_inventaire_show', methods: ['GET'])]
    public function show(Inventaire $inventaire): Response
    {
        return $this->render('inventaire/show.html.twig', [
            'inventaire' => $inventaire,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_inventaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inventaire $inventaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inventaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inventaire/edit.html.twig', [
            'inventaire' => $inventaire,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'app_inventaire_delete', methods: ['POST'])]
    public function delete(Request $request, Inventaire $inventaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventaire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inventaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_inventaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
