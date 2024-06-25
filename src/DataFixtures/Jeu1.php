<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Categorie Guitares
        $c1 = new Categorie();
        $c1->setNom("Guitares");
        $c1->setImage("guitares.png");
        $manager->persist($c1);

        $sc1 = new Categorie();
        $sc1->setNom("Guitares Accoustiques");
        $sc1->setImage("guitares_accoustiques.png");
        $sc1->setParent($c1);
        // $c1->addSousCategorie($sc1);
        $manager->persist($sc1);

        $sc2 = new Categorie();
        $sc2->setNom("Guitares Electriques");
        $sc2->setImage("guitares_electriques.png");
        $sc2->setParent($c1);
        // $c1->addSousCategorie($sc2);
        $manager->persist($sc2);

        $c2 = new Categorie();
        $c2->setNom("Sonorisation");
        $c2->setImage("guitares.png");
        $manager->persist($c2);

        $manager->flush();
    }
}
