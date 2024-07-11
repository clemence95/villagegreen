<?php


// src/Controller/SearchController.php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $searchTerm = $request->query->get('search');
        $type = $request->query->get('type');

        switch ($type) {
            case 'categorie':
                $resultats = $this->entityManager->getRepository(Categorie::class)->findByNom($searchTerm);
                break;
            case 'sous_categorie':
                // Vous devrez ajuster ceci en fonction de votre structure d'entité
                $resultats = $this->entityManager->getRepository(Categorie::class)->findBySousCategorieNom($searchTerm);
                break;
            case 'produit':
                // Vous devrez ajuster ceci en fonction de votre structure d'entité
                $resultats = $this->entityManager->getRepository(Produit::class)->findByNom($searchTerm);
                break;
            default:
                $resultats = [];
                break;
        }

        return $this->render('search/index.html.twig', [
            'searchTerm' => $searchTerm,
            'type' => $type,
            'resultats' => $resultats,
        ]);
    }
}

