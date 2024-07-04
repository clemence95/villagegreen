<?php
// src/EventSubscriber/TwigEventSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private CategorieRepository $categorieRepository;
    private ProduitRepository $produitRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Environment $twig,
        CategorieRepository $categorieRepository,
        ProduitRepository $produitRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->twig = $twig;
        $this->categorieRepository = $categorieRepository;
        $this->produitRepository = $produitRepository;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        // Injecter des variables dans tous les templates
        $this->injectGlobalVariables();
    }

    private function injectGlobalVariables()
    {
        $categories = $this->categorieRepository->findAll(); // Exemple pour récupérer les catégories
        $produits = $this->produitRepository->findAll(); // Exemple pour récupérer les produits

        // Transmettre les variables aux templates Twig
        $this->twig->addGlobal('categories', $categories);
        $this->twig->addGlobal('produits', $produits);
    }
}

