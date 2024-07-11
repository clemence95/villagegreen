<?php

// src/Controller/InscriptionController.php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le mot de passe depuis le champ plainPassword
            $plainPassword = $form->get('plainPassword')->getData();

            if ($plainPassword) {
                // Hash the password
                $hashedPassword = $passwordHasher->hashPassword(
                    $client,
                    $plainPassword
                );
                $client->setPassword($hashedPassword);

                // Set default values for coefficients
                $client->setCoefficientParticulier(1.0); // or any other default value
                $client->setCoefficientProfessionnel(1.0); // or any other default value

                // Set a unique reference client
                $client->setReferenceClient(uniqid('client_'));

                // Assign ROLE_USER by default
                $client->setRoles(['ROLE_USER']);

                $entityManager->persist($client);
                $entityManager->flush();

                return $this->redirectToRoute('login');
            }
        }

        return $this->render('registration/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}







