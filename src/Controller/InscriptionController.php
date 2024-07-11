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
use Symfony\Component\Form\FormFactoryInterface;

class InscriptionController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): Response
    {
        $client = new Client();
        $form = $formFactory->create(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword(
                $client,
                $form->get('plainPassword')->getData()
            );
            $client->setPassword($hashedPassword);

            // Set default values for coefficients
            $client->setCoefficientParticulier(1.0); // or any other default value
            $client->setCoefficientProfessionnel(2.0); // or any other default value

            // Set a unique reference client
            $client->setReferenceClient(uniqid('client_'));

            // Assign ROLE_USER by default
            $client->setRoles(['ROLE_USER']);

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}








