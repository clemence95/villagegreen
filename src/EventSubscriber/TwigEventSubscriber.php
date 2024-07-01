<?php
// src/EventSubscriber/TwigEventSubscriber.php

namespace App\EventSubscriber;

use App\Repository\CategorieRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $categorieRepository;

    public function __construct(Environment $twig, CategorieRepository $categorieRepository)
    {
        $this->twig = $twig;
        $this->categorieRepository = $categorieRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $categories = $this->categorieRepository->findAll();
        $this->twig->addGlobal('categories', $categories);
    }
}
