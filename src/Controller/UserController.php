<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user/creation/compte', name: 'app_user')]
    public function index(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form->get('roles')->getData();
            $password = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            
            $user->setRoles([$roles]);
            $user->setStatus(true); // Set default status
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_liste');
        }
        return $this->render('user/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/liste', name: 'app_user_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_user_liste');
        }

        return $this->render('user/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->redirectToRoute('app_user_liste');
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_user_liste');
    }
}
