<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Employe;
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
        // Création d'un employé (Employe)
        $employe = new Employe();
        $employe->setNom('admin');
        $employe->setRoles(['ROLE_ADMIN']);
        $employe->setPassword($this->passwordHasher->hashPassword($employe, 'password'));
        $employe->setPrenom('John');
        $employe->setEmail('admin@example.com');
        $employe->setTelephone('0123456789');
        $manager->persist($employe);

        // Création d'un client (Client)
        $client = new Client();
        $client->setEmail('client@example.com');
        $client->setRoles(['ROLE_USER']);
        $client->setPassword($this->passwordHasher->hashPassword($client, 'password123'));
        $client->setNom('Doe');
        $client->setPrenom('Jane');
        $client->setSiret('12345678901234');
        $client->setEntreprise('Acme Corp');
        $client->setReferenceClient('REF123456');
        $client->setCoefficient(1.5);
        $client->setTelephone('0123456789');
        $client->setTypeClient('standard');
        // Définir d'autres propriétés si nécessaire

        // Vérification des champs obligatoires avant de persister
        if ($employe->getEmail() !== null && $employe->getPassword() !== null &&
            $client->getEmail() !== null && $client->getPassword() !== null) {
            $manager->persist($employe);
            $manager->persist($client);
            $manager->flush();
        } else {
            throw new \Exception('Les champs obligatoires ne sont pas définis.');
        }
    }
}





