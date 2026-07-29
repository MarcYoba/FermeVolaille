<?php

namespace App\Controller;

use App\Entity\Bloc;
use App\Form\BlocType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlocController extends AbstractController
{
    #[Route('/gestionnaire/bloc/creat', name: 'app_bloc')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $bloc = new Bloc();
        $form = $this->createForm(BlocType::class,$bloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $bloc->setUser($this->getUser());
            $em->persist($bloc);
            $em->flush();

            return $this->redirectToRoute('app_bloc_list');
        }
        return $this->render('bloc/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/gestionnaire/bloc/list', name: 'app_bloc_list')]
    public function bloc(EntityManagerInterface $em) : Response 
    {
        $bloc =  $em->getRepository(Bloc::class)->findAll();
        
        return $this->render('bloc/list.html.twig',[
            'blocs' => $bloc, 
        ]);
    }
    #[Route('/admin/bloc/edit/{id}', name: 'app_bloc_edit')]
    public function  edit(EntityManagerInterface $em, Request $request,int $id) : Response 
    {
        $bloc = $em->getRepository(Bloc::class)->find($id);
        if (!$bloc) {
            return $this->redirectToRoute('app_bloc_list');
        }
        $form = $this->createForm(BlocType::class,$bloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $bloc->setUser($this->getUser());
            $em->flush();
        }
        return $this->render('bloc/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/bloc/delete/{id}', name: 'app_bloc_delete')]
    public function delete(EntityManagerInterface $em, int $id) : Response 
    {
        $bloc = $em->getRepository(Bloc::class)->find($id);
        if (!$bloc) {
            return $this->redirectToRoute('app_bloc_list');
        }
        
        $em->remove($bloc);
        $em->flush();

        return $this->redirectToRoute('app_bloc_list');
    }

}
