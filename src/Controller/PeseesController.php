<?php

namespace App\Controller;

use App\Entity\Pesees;
use App\Form\PeseesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PeseesController extends AbstractController
{
    #[Route('/getionnaire/pesees/new', name: 'app_pesees')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $pesees = new Pesees();
        $form = $this->createForm(PeseesType::class, $pesees);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pesees->setUser($this->getUser());
            $em->persist($pesees);
            $em->flush();


            return $this->redirectToRoute('app_pesees_list');
        }

        return $this->render('pesees/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/getionnaire/pesees/list', name: 'app_pesees_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $pesees = $em->getRepository(Pesees::class)->findAll();

        return $this->render('pesees/list.html.twig', [
            'pesees' => $pesees,
        ]);
    }

    #[Route('/admin/pesees/{id}/edit', name: 'app_pesees_edit')]
    public function edit(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $pesees = $em->getRepository(Pesees::class)->find($id);

        if (!$pesees) {
            return $this->redirectToRoute('app_pesees_list');
        }

        $form = $this->createForm(PeseesType::class, $pesees);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_pesees_list');
        }

        return $this->render('pesees/index.html.twig', [
            'form' => $form->createView(),
            'pesees' => $pesees,
        ]);
    }

    #[Route('/admin/pesees/{id}/delete', name: 'app_pesees_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $pesees = $em->getRepository(Pesees::class)->find($id);

        if ($pesees) {
            $em->remove($pesees);
            $em->flush();
        }

        return $this->redirectToRoute('app_pesees_list');
    }
}
