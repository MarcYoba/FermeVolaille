<?php

namespace App\Controller;

use App\Entity\Batiments;
use App\Form\BatimentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BatimentsController extends AbstractController
{
    #[Route('/gestionnaire/batiments/create', name: 'app_batiments')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $batiments = new Batiments();
        $form = $this->createForm(BatimentType::class, $batiments);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $batiments->setCreatetAt(new \DateTime());
            $batiments->setUser($this->getUser());

            $em->persist($batiments);
            $em->flush();

            return $this->redirectToRoute('app_batiments_list');

        }
        return $this->render('batiments/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/batiment/list', name:'app_batiments_list')]
    public function list(EntityManagerInterface $em) : Response 
    {
       $batiments = $em->getRepository(Batiments::class)->findAll();
       
       return $this->render('batiments/list.html.twig', [
            'batiments' => $batiments,
        ]);
    }

    #[Route('/admin/batiment/edit/{id}', name: 'app_batiments_edit')]
    public function edit(EntityManagerInterface $em, Request $request, int $id) : Response 
    {
       $batiments = $em->getRepository(Batiments::class)->find($id);
       
       if (!$batiments) {
            return $this->redirectToRoute('app_batiments_list');
       }

       $form = $this->createForm(BatimentType::class, $batiments);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $batiments->setCreatetAt(new \DateTime());
            $batiments->setUser($this->getUser());

            $em->persist($batiments);
            $em->flush();

            return $this->redirectToRoute('app_batiments_list');

        }
        return $this->render('batiments/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/batiment/delete/{id}', name: 'app_batiments_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
        $batiments = $em->getRepository(Batiments::class)->find($id);
       
       if (!$batiments) {
            return $this->redirectToRoute('app_batiments_list');
       }

       $em->remove($batiments);
       $em->flush();

       return $this->redirectToRoute('app_batiments_list');
    }
}
