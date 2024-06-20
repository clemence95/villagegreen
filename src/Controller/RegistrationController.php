<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Définir le coefficient pour les utilisateurs particuliers
            if ($utilisateur->getTypeClient() === 'particulier') {
                $utilisateur->setCoefficient(Utilisateur::COEFFICIENT_PARTICULIER);
            } elseif ($utilisateur->getTypeClient() === 'professionnel') {
                $utilisateur->setCoefficient(Utilisateur::COEFFICIENT_PROFESSIONNEL);
            }

            // Générer une référence utilisateur unique
            $utilisateur->setReferenceClient('REF-' . strtoupper(bin2hex(random_bytes(4))));

            // Hash the password
            $utilisateur->setPassword(
                $passwordHasher->hashPassword(
                    $utilisateur,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Peut-être définir un message flash ou rediriger vers une autre page
            return $this->redirectToRoute('app_register_success');
        }

        return $this->render('main/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}






