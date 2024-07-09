<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\InscriptionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Création d'une nouvelle instance de l'entité Client
        $client = new Client();

        // Définition automatique du coefficient en fonction du type de client
        $typeClient = $request->request->get('InscriptionFormType')['type_client'];
        if ($typeClient === 'particulier') {
            $client->setCoefficientParticulier(1.0); // Coefficient pour un client particulier
        } elseif ($typeClient === 'entreprise') {
            $client->setCoefficientProfessionnel(2.0); // Coefficient pour un client professionnel
        }

        // Définition automatique du commercial (par exemple, prenons le premier commercial dans la base de données)
        $commercial = $entityManager->getRepository(Client::class)->findOneBy(['roles' => 'ROLE_COMMERCIAL']);
        $client->setIdCommercial($commercial);

        // Création du formulaire à partir de InscriptionFormType et de l'entité Client (sans les champs de coefficient et de commercial)
        $form = $this->createForm(InscriptionFormType::class, $client, [
            'exclude_fields' => ['coefficient', 'id_commercial'],
        ]);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Encodage du mot de passe
            $encodedPassword = $passwordHasher->hashPassword($client, $client->getPassword());
            $client->setPassword($encodedPassword);

            // Enregistrement des données dans la base de données
            $entityManager->persist($client);
            $entityManager->flush();

            // Redirection vers une page de confirmation ou autre
            return $this->redirectToRoute('inscription_success');
        }

        // Affichage du formulaire dans le template Twig
        return $this->render('registration/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inscription/success', name: 'inscription_success')]
    public function success(): Response
    {
        return $this->render('registration/success.html.twig');
    }
}




