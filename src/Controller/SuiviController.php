<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Form\SuiviType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SuiviController extends AbstractController
{
    #[Route('/gestionnaire/suivi/new', name: 'app_suivi')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $suivi = new Suivi();
        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $suivi->setUser($this->getUser());
            $em->persist($suivi);
            $em->flush();

            return $this->redirectToRoute('app_suivi_list');
        }

        return $this->render('suivi/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/suivi/list', name: 'app_suivi_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $suivis = $em->getRepository(Suivi::class)->findAll();

        return $this->render('suivi/list.html.twig', [
            'suivis' => $suivis,
        ]);
    }

    #[Route('/gestionnaire/suivi/{id}/edit', name: 'app_suivi_edit')]
    public function edit(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $suivi = $em->getRepository(Suivi::class)->find($id);

        if (!$suivi) {
            return $this->redirectToRoute('app_suivi_list');
        }

        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_suivi_list');
        }

        return $this->render('suivi/edit.html.twig', [
            'form' => $form->createView(),
            'suivi' => $suivi,
        ]);
    }

    #[Route('/gestionnaire/suivi/{id}/delete', name: 'app_suivi_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $suivi = $em->getRepository(Suivi::class)->find($id);
        if ($suivi) {
            $em->remove($suivi);
            $em->flush();
        }

        return $this->redirectToRoute('app_suivi_list');
    }
}