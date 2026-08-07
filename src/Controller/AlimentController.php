<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Form\AlimentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AlimentController extends AbstractController
{
    #[Route('/getionnaire/aliment/new', name: 'app_aliment')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $aliment = new Aliment();
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $aliment->setUser($this->getUser());
            $em->persist($aliment);
            $em->flush();

            return $this->redirectToRoute('app_aliment_list');
        }
        return $this->render('aliment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/getionnaire/aliment/list', name: 'app_aliment_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $aliments = $em->getRepository(Aliment::class)->findAll();

        return $this->render('aliment/list.html.twig', [
            'aliments' => $aliments,
        ]);
    }

    #[Route('/admin/aliment/{id}/edit', name: 'app_aliment_edit')]
    public function edit(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $aliment = $em->getRepository(Aliment::class)->find($id);

        if (!$aliment) {
            return $this->redirectToRoute('app_aliment_list');
        }

        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aliment->setUser($this->getUser());
            $em->persist($aliment);
            $em->flush();

            return $this->redirectToRoute('app_aliment_list');
        }

        return $this->render('aliment/index.html.twig', [
            'form' => $form->createView(),
            'aliment' => $aliment,
        ]);
    }

    #[Route('/admin/aliment/{id}/delete', name: 'app_aliment_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $aliment = $em->getRepository(Aliment::class)->find($id);
        if (!$aliment) {
            return $this->redirectToRoute('app_aliment_list');
        }

        $em->remove($aliment);
        $em->flush();

        return $this->redirectToRoute('app_aliment_list');
    }
}

