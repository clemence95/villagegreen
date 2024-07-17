<?php
// src/Controller/ProfilController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        // Rend la vue Twig 'profil/index.html.twig'
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser(),  // Récupère l'utilisateur connecté
        ]);
    }
}
