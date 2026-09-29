<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/admin/user/creation/compte', name: 'app_user')]
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

    #[Route('/admin/user/liste', name: 'app_user_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/edit/{id}', name: 'app_user_edit')]
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

        return $this->render('user/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'app_user_delete')]
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
    #[Route('admin/{id}/change-password', name: 'app_user_change_password', methods: ['POST'])]
    public function changePassword(
        Request $request, 
        User $user, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');

        // Vérification de la sécurité CSRF
        if ($this->isCsrfTokenValid('change_password_' . $user->getId(), $submittedToken)) {
            $newPassword = $request->request->get('new_password');

            if (!empty($newPassword) && strlen($newPassword) >= 6) {
                // Hashage et mise à jour du mot de passe
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);

                $entityManager->flush();
                $this->addFlash('success', 'Le mot de passe de ' . $user->getNom() . ' a été modifié avec succès.');
            } else {
                $this->addFlash('danger', 'Le mot de passe doit contenir au moins 6 caractères.');
            }
        } else {
            $this->addFlash('danger', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('app_user_liste');
    }

    /**
     * Route pour changer le rôle d'un utilisateur
     */
    #[Route('admin/{id}/change-role', name: 'app_user_change_role', methods: ['POST'])]
    public function changeRole(
        Request $request, 
        User $user, 
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('change_role_' . $user->getId(), $submittedToken)) {
            $selectedRole = $request->request->get('role');

            // Liste de tous les rôles autorisés dans votre application
            $allowedRoles = [
                'ROLE_USER',
                'ROLE_ADMIN',
                'ROLE_GESTIONNAIRE',
                'ROLE_BLOC',
                'ROLE_POULAILLER',
                'ROLE_SALLE'
            ];

            if (in_array($selectedRole, $allowedRoles)) {
                // Remplacement du rôle
                $user->setRoles([$selectedRole]);

                $entityManager->flush();
                $this->addFlash('success', 'Le rôle de ' . $user->getNom() . ' a été mis à jour.');
            } else {
                $this->addFlash('danger', 'Rôle sélectionné invalide.');
            }
        } else {
            $this->addFlash('danger', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('app_user_liste');
    }

    #[Route('/show/information', name: 'app_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Page de modification du mot de passe
     */
    #[Route('/change-password', name: 'app_change_password', methods: ['GET', 'POST'])]
    public function changePasswordUser(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            
            // Hashage et mise à jour
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
