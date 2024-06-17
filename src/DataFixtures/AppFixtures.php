<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Document;
use App\Entity\Employe;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create categories
        $categorie = new Categorie();
        $categorie->setNom('Instruments');
        $manager->persist($categorie);

        $sousCategorie = new Categorie();
        $sousCategorie->setNom('Guitares');
        $sousCategorie->setCategorie($categorie);
        $manager->persist($sousCategorie);

        // Create fournisseur
        $fournisseur = new Fournisseur();
        $fournisseur->setNomEntreprise('Yamaha');
        $fournisseur->setContact('John Doe');
        $fournisseur->setTelephone('0123456789');
        $fournisseur->setSiret('12345678901234');
        $manager->persist($fournisseur);

        // Create employe
        $employe = new Employe();
        $employe->setNom('Alice');
        $employe->setRole('Commercial');
        $employe->setEmail('alice@example.com');

        // Hachage du mot de passe de l'employé
        $hashedPasswordEmploye = $this->passwordHasher->hashPassword($employe, 'employePassword');
        $employe->setPassword($hashedPasswordEmploye);
        $manager->persist($employe);

        // Create produit
        $produit = new Produit();
        $produit->setLibelleCourt('Guitare acoustique');
        $produit->setLibelleLong('Guitare acoustique Yamaha FG800');
        $produit->setReferenceFournisseur('FG800');
        $produit->setPrixAchatHT(200.00);
        $produit->setPrixVente(300.00);
        $produit->setStock(50);
        $produit->setPhoto('fg800.jpg');
        $produit->setActif(true);
        $produit->setFournisseur($fournisseur);
        $produit->setCategorie($sousCategorie);
        $produit->setGestionPar($employe);
        $manager->persist($produit);

        // Create client
        $client = new Client();
        $client->setNom('Doe');
        $client->setPrenom('John');
        $client->setEmail('john.doe@example.com');

        // Hachage du mot de passe du client
        $hashedPasswordClient = $this->passwordHasher->hashPassword($client, 'password');
        $client->setPassword($hashedPasswordClient);

        $client->setRue('123 Main St');
        $client->setVille('Paris');
        $client->setCodePostal('75001');
        $client->setPays('France');
        $client->setReferenceClient('JD001');
        $client->setTypeClient('Particulier');
        $client->setCoefficient(1.2);
        $client->setCommercial($employe);
        $manager->persist($client);

        // Create commande
        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setTotal(360.00);
        $commande->setStatut('En cours');
        $commande->setAdresseLivraison('123 Main St, Paris, 75001, France');
        $commande->setAdresseFacturation('123 Main St, Paris, 75001, France');
        $commande->setModeReglement('Carte bancaire');
        $commande->setInformationReglement('xxxx-xxxx-xxxx-1234');
        $commande->setReduction(0);
        $commande->setClient($client);
        $commande->addProduit($produit);
        $commande->setReductionGereePar($employe);
        $manager->persist($commande);

        // Create document
        $document = new Document();
        $document->setDate(new \DateTime());
        $document->setTotal(360.00);
        $document->setAdresseLivraison('123 Main St, Paris, 75001, France');
        $document->setAdresseFacturation('123 Main St, Paris, 75001, France');
        $document->setType('Facture');
        $document->setCommande($commande);
        $manager->persist($document);

        $manager->flush();
    }
}

