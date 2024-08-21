<?php
// src/Controller/DashboardController.php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {
        // Vérification que l'utilisateur a le rôle ROLE_ADMIN
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categories = $categorieRepository->findAll();
        $produits = $produitRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
        ]);
    }
}


