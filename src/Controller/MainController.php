<?php

// src/Controller/MainController.php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $categories = $this->categorieRepository->findMainCategories();
        $allSousCategories = $this->categorieRepository->getAllSousCategories();
        shuffle($allSousCategories);
        $randomSousCategories = array_slice($allSousCategories, 0, 5);
        $produits = $this->entityManager->getRepository(Produit::class)->findBy([], [], 5);

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
            'randomSousCategories' => $randomSousCategories,
            'produits' => $produits,
        ]);
    }

    #[Route('/categorie/{nom}', name: 'categorie')]
    public function categorie(string $nom): Response
    {
        $categorie = $this->categorieRepository->findOneBy(['nom' => $nom]);

        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        $sousCategories = $categorie->getSousCategories();

        return $this->render('main/categorie.html.twig', [
            'categorie' => $categorie,
            'sousCategories' => $sousCategories,
        ]);
    }

    #[Route('/categorie/{categorieId}/sous-categorie/{sousCategorieId}', name: 'sous_categorie')]
    public function sousCategorie(int $categorieId, int $sousCategorieId): Response
    {
        $categorie = $this->categorieRepository->find($categorieId);

        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        // Recherche de la sous-catégorie dans la catégorie donnée
        $sousCategorie = null;
        foreach ($categorie->getSousCategories() as $sc) {
            if ($sc->getId() === $sousCategorieId) {
                $sousCategorie = $sc;
                break;
            }
        }

        if (!$sousCategorie) {
            throw new NotFoundHttpException('La sous-catégorie demandée n\'existe pas dans cette catégorie.');
        }

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

    #[Route('/produits', name: 'produits')]
    public function produits(): Response
    {
        $sousCategories = $this->categorieRepository->getAllSousCategories();

        return $this->render('main/produit.html.twig', [
            'sousCategories' => $sousCategories,
        ]);
    }

    #[Route('/produit/{id}', name: 'produit_details')]
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('main/details.html.twig', [
            'produit' => $produit,
        ]);
    }
}



