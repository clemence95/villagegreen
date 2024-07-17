<?php

// src/Controller/ProfilController.php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les commandes de l'utilisateur
        $commandes = $entityManager->getRepository(Commande::class)->findBy(['client' => $user]);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'commandes' => $commandes,
        ]);
    }
}
