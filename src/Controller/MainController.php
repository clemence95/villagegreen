<?php
// src/Controller/MainController.php
namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private CategorieRepository $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $categories = $this->categorieRepository->findAll();

        // Mélanger les sous-catégories pour chaque catégorie
        foreach ($categories as $categorie) {
            $sousCategories = $categorie->getSousCategories()->toArray();
            shuffle($sousCategories); // Mélange aléatoire des sous-catégories
            foreach ($sousCategories as $sousCategorie) {
                $categorie->addSousCategorie($sousCategorie);
            }
        }

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
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
    public function sousCategorie(int $categorieId, int $sousCategorieId): Response
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

