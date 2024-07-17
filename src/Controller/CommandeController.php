<?php

// src/Controller/CommandeController.php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'commander')]
    public function commander(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $session = $request->getSession();
        $panier = $session->get('panier', []);
        $produits = [];
        $totalHT = 0;
        $totalTTC = 0;
        $tva = 0.2;

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
        $user = $this->getUser();
        $form = $this->createForm(CommandeType::class, $commande, ['user' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraison = $form->get('adresse_livraison')->getData();
            $facturation = $form->get('adresse_facturation')->getData();

            $entityManager->persist($livraison);
            $entityManager->persist($facturation);

            $commande->setAdresseLivraison($livraison);
            $commande->setAdresseFacturation($facturation);
            $commande->setClient($this->getUser());
            $commande->setDateCommande(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $commande->setStatut('En attente');
            $commande->setMontantTotal($totalTTC);
            $entityManager->persist($commande);
            $entityManager->flush();

            $commande->setBonLivraison($this->generateBonLivraison($commande));
            $commande->setFacture($this->generateFacture($commande));
            $entityManager->flush();

            $session->remove('panier');

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
        return 'bon_de_livraison_' . $commande->getId() . '.pdf';
    }

    private function generateFacture(Commande $commande): string
    {
        return 'facture_' . $commande->getId() . '.pdf';
    }
}








