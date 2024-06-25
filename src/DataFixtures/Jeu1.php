<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Génération de 5 catégories
        for ($i = 1; $i <= 5; $i++) {
            $categorie = new Categorie();
            $categorie->setNom("Catégorie $i");
            $categorie->setImage("categorie_$i.png");
            $manager->persist($categorie);

            // Génération de 5 sous-catégories pour chaque catégorie
            for ($j = 1; $j <= 5; $j++) {
                $sousCategorie = new Categorie();
                $sousCategorie->setNom("Sous-catégorie $j de Catégorie $i");
                $sousCategorie->setImage("sous_categorie_$j.png");
                $categorie->addSousCategorie($sousCategorie); // Ajouter la sous-catégorie à la catégorie parente
                $manager->persist($sousCategorie);

                // Génération de 5 produits pour chaque sous-catégorie
                for ($k = 1; $k <= 5; $k++) {
                    $produit = new Produit();
                    $produit->setLibelleCourt("Produit $k de Sous-catégorie $j de Catégorie $i");
                    $produit->setLibelleLong("Description détaillée du Produit $k");
                    $produit->setReferenceFournisseur("REF-$i-$j-$k");
                    $produit->setPrixAchat(10.0 * $k); // Exemple de prix d'achat calculé
                    $produit->setPrixVente(15.0 * $k); // Exemple de prix de vente calculé
                    $produit->setStock(100); // Exemple de stock initial
                    $produit->setActif(true); // Exemple de produit actif par défaut
                    $produit->setIdCategorie($categorie); // Associer le produit à la catégorie
                    $produit->setSousCategorie($sousCategorie); // Associer le produit à la sous-catégorie
                    $manager->persist($produit);
                }
            }
        }

        $manager->flush();
    }
}



