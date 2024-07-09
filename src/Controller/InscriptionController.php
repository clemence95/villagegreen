<?php

use App\Entity\Client;
use App\Form\InscriptionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class inscriptionController extends AbstractController
{
    
    #[Route('/inscription', name: 'app_inscription')]
    public function app_inscription (Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Client
        $client = new Client();

        // Création du formulaire à partir de InscriptionFormType et de l'entité Client
        $form = $this->createForm(InscriptionFormType::class, $client);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrement des données dans la base de données
            $entityManager->persist($client);
            $entityManager->flush();

            // Redirection vers une page de confirmation ou autre
            return $this->redirectToRoute('inscription_success');
        }

        // Affichage du formulaire dans le template Twig
        return $this->render('regisration/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/inscription/success', name:'inscription_success')]
    public function success(): Response
    {
        return $this->render('inscription/success.html.twig');
    }
}

