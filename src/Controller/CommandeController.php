<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'commander')]
    public function commander(AuthenticationUtils $authenticationUtils): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Logique pour le traitement de la commande
        return $this->render('commande/index.html.twig', [
            'message' => 'Votre commande a été passée avec succès !',
        ]);
    }
}
