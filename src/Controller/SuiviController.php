<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Form\SuiviType;
use App\Repository\SuiviRepository;
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

        // Optionnel : Pré-remplir la date du jour si elle est vide
        if (!$suivi->getCreatetAt()) {
            $suivi->setCreatetAt(new \DateTime());
        }

        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $suivi->setUser($this->getUser());
            $em->persist($suivi);
            $em->flush();

            return $this->redirectToRoute('app_suivi_list',[],Response::HTTP_SEE_OTHER);
        }

        // Détection de la WebView Android
        $isWebView = $request->headers->has('X-App-WebView') 
            || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';

        $response = $this->render('suivi/index.html.twig', [
            'form' => $form->createView(),
            'suivi' => $suivi,
            'is_webview' => $isWebView,
        ]);

        // Retourne un code HTTP 422 si le formulaire contient des erreurs
        if ($form->isSubmitted() && !$form->isValid()) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Empêche Android de garder en mémoire un formulaire partiellement rempli
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;

    }

    #[Route('/gestionnaire/suivi/list', name: 'app_suivi_list')]
    public function list(SuiviRepository $suiviRepository, Request $request): Response
    {
        // 1. Récupération des suivis triés du plus récent au plus ancien (pratique pour l'app mobile)
        $suivis = $suiviRepository->findBy([], ['id' => 'DESC']);

        // 2. Détection de la WebView Android via l'en-tête HTTP
        $isWebView = $request->headers->has('X-App-WebView') 
            || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';

        $response = $this->render('suivi/list.html.twig', [
            'suivis' => $suivis,
            'is_webview' => $isWebView,
        ]);

        // 3. Invalidation du cache pour garantir l'actualisation après un ajout/suppression
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    #[Route('/gestionnaire/suivi/{id}/edit', name: 'app_suivi_edit')]
    public function edit(EntityManagerInterface $em, Suivi $suivi, Request $request): Response
    {
        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            // HTTP 303 (SEE_OTHER) pour éviter le renvoi de formulaire si l'utilisateur fait "Retour" dans l'app
            return $this->redirectToRoute('app_suivi_list',[],Response::HTTP_SEE_OTHER);
        }
        
        // Détection de la WebView via un en-tête personnalisé envoyé par Android
        $isWebView = $request->headers->has('X-App-WebView') || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';

        $response = $this->render('suivi/index.html.twig', [
            'form' => $form->createView(),
            'suivi' => $suivi,
            'is_webview' => $isWebView,
        ]);

        // Code HTTP 422 en cas d'erreur de validation (nécessaire pour la fluidité avec Turbo / Mobile)
        if ($form->isSubmitted() && !$form->isValid()) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Empêche la WebView d'Android de mettre en cache un formulaire d'édition obsolète
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }

    #[Route('/gestionnaire/suivi/{id}/delete', name: 'app_suivi_delete', methods: ['POST'])]
    public function delete(Suivi $suivi, Request $request, EntityManagerInterface $em): Response
    {
        // 1. Validation obligatoire du jeton CSRF pour des raisons de sécurité
        if ($this->isCsrfTokenValid('delete' . $suivi->getId(), $request->request->get('_token'))) {
            $em->remove($suivi);
            $em->flush();

            $this->addFlash('success', 'Le suivi a bien été supprimé.');
        } else {
            $this->addFlash('error', 'Action non autorisée (jeton CSRF invalide).');
        }

        // 2. HTTP 303 (SEE_OTHER) pour forcer une redirection GET après un POST
        return $this->redirectToRoute('app_suivi_list', [], Response::HTTP_SEE_OTHER);
    }
}