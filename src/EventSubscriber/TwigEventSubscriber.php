<?php
// src/EventSubscriber/TwigEventSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use App\Repository\CategorieRepository;
use App\Controller\MainController; // Importez MainController

class TwigEventSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private CategorieRepository $categorieRepository;

    public function __construct(Environment $twig, CategorieRepository $categorieRepository)
    {
        $this->twig = $twig;
        $this->categorieRepository = $categorieRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        // Injecter le repository des catégories dans le contrôleur si c'est une instance de MainController
        if (is_array($controller) && $controller[0] instanceof MainController) {
            $controller[0]->setCategorieRepository($this->categorieRepository);
            // Récupérer et transmettre les catégories à toutes les vues
            $categories = $this->categorieRepository->findMainCategories();
            $this->twig->addGlobal('categories', $categories);
        }
    }
}
