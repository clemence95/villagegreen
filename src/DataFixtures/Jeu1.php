<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un fournisseur d'instruments de musique
        $fournisseur1 = new Fournisseur();
        $fournisseur1->setNomEntreprise("Musique & Co");
        $fournisseur1->setContact("contact@musiqueandco.com");
        $fournisseur1->setTelephone("0123456789");
        $fournisseur1->setSiret("12345678900001");
        $fournisseur1->setImportateur(true);
        $fournisseur1->setFabricant(false);
        $manager->persist($fournisseur1);

        // Création de catégories principales et leurs sous-catégories pour les instruments de musique
        $categories = [
            'Cordes' => ['Guitares', 'Violons', 'Violoncellos'],
            'Vent' => ['Flûtes', 'Clarinets', 'Saxophones'],
            'Percussions' => ['Tambours', 'Xylophones', 'Batteries'],
            'Claviers' => ['Pianos', 'Synthétiseurs', 'Orgues'],
            'Électroniques' => ['Guitares électriques', 'Claviers électriques', 'Batteries électroniques']
        ];

        foreach ($categories as $catName => $subCategories) {
            $categorie = new Categorie();
            $categorie->setNom($catName);
            $categorie->setImage($this->getRandomImageUrl());
            $manager->persist($categorie);

            foreach ($subCategories as $subCatName) {
                $sousCategorie = new Categorie();
                $sousCategorie->setNom($subCatName);
                $sousCategorie->setImage($this->getRandomImageUrl());
                $sousCategorie->setCategorieParent($categorie);
                $manager->persist($sousCategorie);

                // Génération de produits pour chaque sous-catégorie
                for ($k = 1; $k <= 5; $k++) {
                    $produit = new Produit();
                    $produit->setLibelleCourt("$subCatName $k");
                    $produit->setLibelleLong("Description détaillée du $subCatName $k");
                    $produit->setReferenceFournisseur("REF-$catName-$subCatName-$k");
                    $produit->setPrixAchat(100.0 * $k);
                    $produit->setPrixVente(150.0 * $k);
                    $produit->setStock(10 + $k);
                    $produit->setActif(true);
                    $produit->setSousCategorie($sousCategorie);
                    $produit->setPhoto($this->getRandomImageUrl());
                    $produit->setIdFournisseur($fournisseur1);
                    $manager->persist($produit);
                }
            }
        }

        $manager->flush();
    }

    private function getRandomImageUrl(): string
    {
        return 'https://picsum.photos/200/300';
    }
}












