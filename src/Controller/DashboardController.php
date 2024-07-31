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
        $categories = $categorieRepository->findAll();
        $produits = $produitRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
        ]);
    }
}



