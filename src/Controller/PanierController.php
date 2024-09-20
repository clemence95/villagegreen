<?php

// src/Controller/PanierController.php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PanierController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/panier', name: 'panier')]
    public function panier(SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $produits = [];
        $totalPrix = 0;
        $totalQuantite = 0;
    
        // Récupérer le client actuel ou null si non connecté
        $client = $this->getUser();
    
        foreach ($panier as $id => $quantite) {
            $produit = $this->entityManager->getRepository(Produit::class)->find($id);
            if ($produit) {
                // Calculer le prix de vente HT en utilisant la méthode avec gestion du coefficient par défaut
                $prixVenteHT = $produit->calculerPrixVenteHT($client);
    
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'prixVenteHT' => $prixVenteHT
                ];
    
                // Utiliser le prix de vente HT pour calculer le total
                $totalPrix += $prixVenteHT * $quantite;
                $totalQuantite += $quantite;
            }
        }
    
        return $this->render('panier/index.html.twig', [
            'produits' => $produits,
            'totalPrix' => $totalPrix,
            'totalQuantite' => $totalQuantite,
        ]);
    }
    
    #[Route('/panier/ajouter/{id}', name: 'panier_ajouter')]
    public function ajouterAuPanier(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (!array_key_exists($id, $panier)) {
            $panier[$id] = 0;
        }

        $panier[$id]++;
        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/diminuer/{id}', name: 'panier_diminuer')]
    public function diminuerQuantite(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (array_key_exists($id, $panier)) {
            $panier[$id]--;
            if ($panier[$id] <= 0) {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'panier_supprimer')]
    public function supprimerDuPanier(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (array_key_exists($id, $panier)) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }

    #[Route('/api/panier/count', name: 'api_panier_count')]
    public function getPanierCount(SessionInterface $session): JsonResponse
    {
        $panier = $session->get('panier', []);
        $totalQuantite = array_sum($panier);

        return new JsonResponse(['count' => $totalQuantite]);
    }
}
