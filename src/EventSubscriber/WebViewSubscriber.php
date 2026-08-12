<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class WebViewSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            // Écoute l'événement juste avant l'exécution du contrôleur
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        // Ignore les sous-requêtes (ex: fragments Twig ou appels internes)
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Détection du header WebView (Personnalisé ou Android standard)
        $isWebView = $request->headers->has('X-App-WebView') 
            || $request->headers->get('X-Requested-With') === 'com.tonentreprise.tonapp';

        // Injection globale dans Twig
        $this->twig->addGlobal('is_webview', $isWebView);
    }
}