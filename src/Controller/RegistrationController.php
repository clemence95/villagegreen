<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
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
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Définir le coefficient pour les clients particuliers
            if ($client->getTypeClient() === 'particulier') {
                $client->setCoefficient(Client::COEFFICIENT_PARTICULIER);
            } elseif ($client->getTypeClient() === 'professionnel') {
                $client->setCoefficient($client->getCoefficient() ?? Client::COEFFICIENT_PROFESSIONNEL);
            }

            // Hash the password
            $client->setPassword(
                $passwordHasher->hashPassword(
                    $client,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($client);
            $entityManager->flush();

            // Peut-être définir un message flash ou rediriger vers une autre page
            return $this->redirectToRoute('app_register_success');
        }

        return $this->render('main/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}




