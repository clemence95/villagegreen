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
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InscriptionController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, MailerInterface $mailer): Response
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

            // Set default values for coefficients based on client type
            if ($form->get('type_client')->getData() === 'particulier') {
                $client->setCoefficient('2.0'); // Coefficient par défaut pour un particulier
            } elseif ($form->get('type_client')->getData() === 'professionnel') {
                $client->setCoefficient('1.0'); // Coefficient par défaut pour un professionnel
            }

            // Set a unique reference client
            $client->setReferenceClient(uniqid('client_'));

            // Assign ROLE_USER by default
            $client->setRoles(['ROLE_USER']);

            // Generate a unique confirmation token
            $client->setConfirmationToken(uniqid('confirm_', true));

            $entityManager->persist($client);
            $entityManager->flush();

            // Generate confirmation link
            $confirmationLink = $this->generateUrl('app_confirm_email', [
                'token' => $client->getConfirmationToken(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);

            // Send confirmation email
            $email = (new Email())
                ->from('no-reply@yourdomain.com')
                ->to($client->getEmail())
                ->subject('Confirmez votre inscription')
                ->html($this->renderView('emails/confirmation.html.twig', [
                    'client' => $client,
                    'confirmationLink' => $confirmationLink,
                ]));

            $mailer->send($email);

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/confirm-email', name: 'app_confirm_email')]
    public function confirmEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $token = $request->query->get('token');

        $client = $entityManager->getRepository(Client::class)->findOneBy(['confirmationToken' => $token]);

        if ($client) {
            $client->setIsEmailConfirmed(true);
            $client->setConfirmationToken(null);
            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Votre email a été confirmé avec succès !');
        } else {
            $this->addFlash('error', 'Le token de confirmation est invalide.');
        }

        return $this->redirectToRoute('login');
    }
}


// php bin/console messenger:consume async
// MailHog
// symfony serve
