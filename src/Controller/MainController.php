<?php
// src/Controller/MainController.php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CategorieRepository $categorieRepository, EntityManagerInterface $entityManager)
    {
        $this->categorieRepository = $categorieRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        // Récupérer 5 catégories principales
        $categories = $this->categorieRepository->findMainCategories();

        // Récupérer toutes les sous-catégories
        $allSousCategories = $this->categorieRepository->getAllSousCategories();

        // Mélanger toutes les sous-catégories
        shuffle($allSousCategories);

        // Limiter à 5 sous-catégories aléatoires
        $randomSousCategories = array_slice($allSousCategories, 0, 5);

        // Récupérer les 5 premiers produits (exemple)
        $produits = $this->entityManager->getRepository(Produit::class)->findBy([], [], 5);

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
            'randomSousCategories' => $randomSousCategories,
            'produits' => $produits,
        ]);
    }

    #[Route('/categorie/{id}', name: 'categorie')]
    public function categorie(int $id): Response
    {
        // Récupérer la catégorie principale par son ID
        $categorie = $this->categorieRepository->find($id);
    
        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }
    
        // Récupérer les sous-catégories de la catégorie principale
        $sousCategories = $categorie->getSousCategories();
    
        return $this->render('main/categorie.html.twig', [
            'categorie' => $categorie,
            'sousCategories' => $sousCategories,
        ]);
    }
    
    #[Route('/categorie/{categorieId}/sous-categorie/{sousCategorieId}', name: 'sous_categorie')]
    public function sousCategorie(string $sousCategorieId): Response
    {
        // Récupérer la sous-catégorie par son ID
        $sousCategorie = $this->categorieRepository->find($sousCategorieId);

        if (!$sousCategorie) {
            throw $this->createNotFoundException('La sous-catégorie demandée n\'existe pas.');
        }

        // Récupérer les produits associés à la sous-catégorie
        $produits = $sousCategorie->getProduits();

        return $this->render('main/sous_categorie.html.twig', [
            'sousCategorie' => $sousCategorie,
            'produits' => $produits,
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/profil.html.twig');
    }
}
