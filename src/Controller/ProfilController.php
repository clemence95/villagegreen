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
            // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Vérifier que l'utilisateur a bien les droits de voir son propre profil
        $this->denyAccessUnlessGranted('view_user', $user);

        // Récupérer les commandes de l'utilisateur
        $commandes = [];

        if ($user instanceof \App\Entity\Client) {
            $commandes = $entityManager->getRepository(Commande::class)->findBy(['client' => $user]);
        } elseif ($user instanceof \App\Entity\Employe) {
            $commandes = $entityManager->getRepository(Commande::class)->findBy(['employe' => $user]);
        }

        // Rendre la vue profil avec les informations utilisateur et les commandes
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'commandes' => $commandes,
        ]);
    }
}


