<?php

namespace App\Controller;

use App\Entity\LigneProduction;
use App\Form\LigneProductionType;
use App\Repository\LigneProductionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ligne/production')]
final class LigneProductionController extends AbstractController
{
    #[Route(name: 'app_ligne_production_index', methods: ['GET'])]
    public function index(LigneProductionRepository $ligneProductionRepository): Response
    {
        return $this->render('ligne_production/index.html.twig', [
            'ligne_productions' => $ligneProductionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_production_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneProduction = new LigneProduction();
        $form = $this->createForm(LigneProductionType::class, $ligneProduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneProduction);
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_production/new.html.twig', [
            'ligne_production' => $ligneProduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_production_show', methods: ['GET'])]
    public function show(LigneProduction $ligneProduction): Response
    {
        return $this->render('ligne_production/show.html.twig', [
            'ligne_production' => $ligneProduction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_production_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneProduction $ligneProduction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneProductionType::class, $ligneProduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_production/edit.html.twig', [
            'ligne_production' => $ligneProduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_production_delete', methods: ['POST'])]
    public function delete(Request $request, LigneProduction $ligneProduction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneProduction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ligneProduction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ligne_production_index', [], Response::HTTP_SEE_OTHER);
    }
}
