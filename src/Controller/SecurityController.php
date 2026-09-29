<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
           
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Détection de la WebView Android
        $isWebView = $request->headers->has('X-App-WebView') 
            || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';
        
            // Redirige l'utilisateur s'il est déjà connecté
        if ($this->getUser()) {
            // Si l'utilisateur est un Admin ou un Gestionnaire
            if ($this->isGranted('ROLE_GESTIONNAIRE')) {
                return $this->redirectToRoute('app_gestionnaire'); // Modifiez 'app_gestionnaire' par le nom exact de votre route
            }

            // Sinon, redirection par défaut pour un utilisateur simple
            return $this->redirectToRoute('app_home');
        }

        $response = $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'is_webview'    => $isWebView,
        ]);

        // Empêche la mise en cache de la page de connexion sur le navigateur / mobile
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
