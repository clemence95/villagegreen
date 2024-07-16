<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'commander')]
    public function commander(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le panier depuis la session
        $session = $request->getSession();
        $panier = $session->get('panier', []);
        $produits = [];
        $totalHT = 0;
        $totalTTC = 0;
        $tva = 0.2; // Supposons une TVA de 20%

        foreach ($panier as $id => $quantite) {
            $produit = $entityManager->getRepository(Produit::class)->find($id);
            if ($produit) {
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'totalHT' => $produit->getPrixVente() * $quantite,
                    'totalTTC' => $produit->getPrixVente() * $quantite * (1 + $tva)
                ];
                $totalHT += $produit->getPrixVente() * $quantite;
            }
        }
        $totalTTC = $totalHT * (1 + $tva);

        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer la commande dans la base de données
            $commande->setIdClient($this->getUser());
            $commande->setDateCommande(new \DateTime());
            $commande->setStatut('En attente');
            $commande->setMontantTotal($totalTTC);
            $entityManager->persist($commande);
            $entityManager->flush();

            // Générer le bon de livraison et la facture
            $commande->setBonLivraison($this->generateBonLivraison($commande));
            $commande->setFacture($this->generateFacture($commande));
            $entityManager->flush();

            // Vider le panier après la commande
            $session->remove('panier');

            // Rediriger vers une page de succès ou afficher un message de succès
            return $this->redirectToRoute('commande_success');
        }

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
        ]);
    }

    #[Route('/commande/success', name: 'commande_success')]
    public function success(): Response
    {
        return $this->render('commande/success.html.twig', [
            'message' => 'Votre commande a été passée avec succès !',
        ]);
    }

    private function generateBonLivraison(Commande $commande): string
    {
        // Logique pour générer le bon de livraison
        // Par exemple, générer un PDF et retourner le chemin ou l'URL
        return 'chemin/vers/bon/livraison.pdf';
    }

    private function generateFacture(Commande $commande): string
    {
        // Logique pour générer la facture
        // Par exemple, générer un PDF et retourner le chemin ou l'URL
        return 'chemin/vers/facture.pdf';
    }
}



