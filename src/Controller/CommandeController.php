<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Document;
use App\Form\CommandeType;
use App\Entity\CommandeProduit;
use App\Service\AdresseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'commander')]
    public function commander(Request $request, EntityManagerInterface $entityManager, AdresseService $adresseService): Response
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
    
        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('panier');
        }
    
        // Récupération du client connecté et vérification que c'est bien un objet Client
        $client = $this->getUser();
        if (!$client instanceof Client) {
            throw new \Exception('L\'utilisateur connecté n\'est pas un client.');
        }
    
        // Calcul des prix pour chaque produit dans le panier
        foreach ($panier as $id => $quantite) {
            $produit = $entityManager->getRepository(Produit::class)->find($id);
            if ($produit) {
                // Utilisation de la méthode calculerPrixVenteHT pour calculer le prix HT
                $prixVenteHT = $produit->calculerPrixVenteHT($client);
    
                // Utilisation de la méthode calculerPrixVenteTTC pour calculer le prix TTC
                $prixVenteTTC = $produit->calculerPrixVenteTTC($client, (string)$tva);
    
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'totalHT' => $prixVenteHT * $quantite,
                    'totalTTC' => $prixVenteTTC * $quantite,
                ];
    
                $totalHT += $prixVenteHT * $quantite;
                $totalTTC += $prixVenteTTC * $quantite;
            }
        }
    
        // Création de la commande
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande, ['user' => $client]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $livraison = $form->get('adresse_livraison')->getData();
            $facturation = $form->get('adresse_facturation')->getData();
    
            $livraison = $adresseService->findOrCreateAdresse($livraison);
            $facturation = $adresseService->findOrCreateAdresse($facturation);
    
            $commande->setAdresseLivraison($livraison);
            $commande->setAdresseFacturation($facturation);
            $commande->setClient($client);
    
            $commande->setDateCommande(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $commande->setStatut('En attente');
            $commande->setMontantTotal($totalTTC);
            $entityManager->persist($commande);
            $entityManager->flush();  // Persiste la commande et obtenir son ID
    
            // Insérer les produits commandés
            foreach ($panier as $id => $quantite) {
                $produit = $entityManager->getRepository(Produit::class)->find($id);
                if ($produit) {
                    $commandeProduit = new CommandeProduit();
                    $commandeProduit->setCommande($commande);
                    $commandeProduit->setProduit($produit);
                    $commandeProduit->setQuantite((float)$quantite);
    
                    $entityManager->persist($commandeProduit);
                }
            }
    
            $entityManager->flush();  // Persiste les CommandeProduits
    
            // Génération des documents après la commande
            $bonLivraisonFileName = $this->generateBonLivraison($commande);
            $bonLivraisonDocument = new Document();
            $bonLivraisonDocument->setType(Document::TYPE_BON_LIVRAISON);
            $bonLivraisonDocument->setDateCreation(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $bonLivraisonDocument->setFileName($bonLivraisonFileName);
            $bonLivraisonDocument->setCommande($commande);
    
            $entityManager->persist($bonLivraisonDocument);
    
            $factureFileName = $this->generateFacture($commande);
            $factureDocument = new Document();
            $factureDocument->setType(Document::TYPE_FACTURE);
            $factureDocument->setDateCreation(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $factureDocument->setFileName($factureFileName);
            $factureDocument->setCommande($commande);
    
            $entityManager->persist($factureDocument);
    
            $entityManager->flush(); // Enregistrer les documents dans la base de données
    
            $session->remove('panier'); // Vider le panier après la commande
    
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
        $dompdf = new Dompdf();
        $currentDateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $html = $this->renderView('pdf/bon_livraison.html.twig', [
            'commande' => $commande,
            'commandeProduits' => $commande->getCommandeProduits(), // Ajouter les produits ici
            'currentDateTime' => $currentDateTime,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $fileName = 'bon_de_livraison_' . $commande->getId() . '.pdf';
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/documents/' . $fileName;
        file_put_contents($filePath, $dompdf->output());
    
        return $fileName;
    }

    private function generateFacture(Commande $commande): string
    {
        $dompdf = new Dompdf();
        $currentDateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $html = $this->renderView('pdf/facture.html.twig', [
            'commande' => $commande,
            'commandeProduits' => $commande->getCommandeProduits(), // Ajouter les produits ici
            'currentDateTime' => $currentDateTime,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $fileName = 'facture_' . $commande->getId() . '.pdf';
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/documents/' . $fileName;
        file_put_contents($filePath, $dompdf->output());
    
        return $fileName;
    }
}




