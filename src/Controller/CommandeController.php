<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Produit;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
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
            $entityManager->flush();  // Persist the Commande first to get its ID

            foreach ($panier as $id => $quantite) {
                $produit = $entityManager->getRepository(Produit::class)->find($id);
                if ($produit) {
                    $commandeProduit = new CommandeProduit();
                    $commandeProduit->setCommande($commande);
                    $commandeProduit->setProduit($produit);
                    $commandeProduit->setQuantite((float)$quantite);  // Store as decimal

                    $entityManager->persist($commandeProduit);
                }
            }

            $entityManager->flush();

            // Generate PDFs for Bon de Livraison and Facture
            $bonLivraison = $this->generateBonLivraison($commande);
            $facture = $this->generateFacture($commande);

            $commande->setBonLivraison($bonLivraison);
            $commande->setFacture($facture);
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
        $dompdf = new Dompdf();
        $html = $this->renderView('pdf/bon_livraison.html.twig', ['commande' => $commande]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'bon_de_livraison_' . $commande->getId() . '.pdf';
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/bons_livraison/' . $fileName;
        file_put_contents($filePath, $dompdf->output());

        return $fileName;
    }

    private function generateFacture(Commande $commande): string
    {
        $dompdf = new Dompdf();
        $html = $this->renderView('pdf/facture.html.twig', ['commande' => $commande]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'facture_' . $commande->getId() . '.pdf';
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/factures/' . $fileName;
        file_put_contents($filePath, $dompdf->output());

        return $fileName;
    }
}










