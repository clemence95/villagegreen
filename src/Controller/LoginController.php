<?php

// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs de connexion, s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Si l'utilisateur est déjà connecté, redirigez-le
        if ($this->getUser()) {
            // Redirection basée sur le rôle
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_dashboard');
            } elseif ($this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('app_profil');
            }
        }

        // Afficher le formulaire de connexion
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(Request $request, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Vérifiez si l'utilisateur est un admin (ou a un autre rôle spécifique)
        if ($this->isGranted('ROLE_ADMIN')) {
            // Créer un token JWT pour l'utilisateur
            $token = $JWTManager->create($user);

            // Retourner le token dans la réponse
            return new JsonResponse(['token' => $token]);
        }

        // Si l'utilisateur n'est pas un admin, retournez une réponse d'accès refusé
        return new JsonResponse(['error' => 'Access denied for API'], JsonResponse::HTTP_FORBIDDEN);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Ce contrôleur peut être vide : il ne sera jamais appelé !
        throw new \Exception('N\'oubliez pas d\'activer la déconnexion dans security.yaml');
    }
}






