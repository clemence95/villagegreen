<?php
// src/Controller/ProfilController.php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les commandes de l'utilisateur
        $commandes = $entityManager->getRepository(Commande::class)->findBy(['client' => $user]);

        // Créer et traiter le formulaire d'adresse de livraison
        $adresse = $user->getAdresseLivraison() ?: new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAdresseLivraison($adresse);
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash('success', 'Adresse mise à jour avec succès.');

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'commandes' => $commandes,
            'form' => $form->createView(),
        ]);
    }
}

