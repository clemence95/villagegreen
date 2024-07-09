<?php

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

        // Création d'un client particulier (Client)
        $clientParticulier = new Client();
        $clientParticulier->setEmail('clientparticulier@example.com');
        $clientParticulier->setRoles(['ROLE_USER']);
        $clientParticulier->setPassword($this->passwordHasher->hashPassword($clientParticulier, 'password123'));
        $clientParticulier->setNom('Doe');
        $clientParticulier->setPrenom('Jane');
        $clientParticulier->setSiret('12345678901234');
        $clientParticulier->setEntreprise('Acme Corp');
        $clientParticulier->setReferenceClient('REF123456');
        $clientParticulier->setTelephone('0123456789');
        $clientParticulier->setTypeClient('particulier');
        $clientParticulier->setCoefficientParticulier(1.0); // Coefficient pour un client particulier
        $manager->persist($clientParticulier);

        // Création d'un client professionnel (Client)
        $clientProfessionnel = new Client();
        $clientProfessionnel->setEmail('clientprofessionnel@example.com');
        $clientProfessionnel->setRoles(['ROLE_USER']);
        $clientProfessionnel->setPassword($this->passwordHasher->hashPassword($clientProfessionnel, 'password456'));
        $clientProfessionnel->setNom('Smith');
        $clientProfessionnel->setPrenom('John');
        $clientProfessionnel->setSiret('56789012345678');
        $clientProfessionnel->setEntreprise('Tech Solutions');
        $clientProfessionnel->setReferenceClient('REF987654');
        $clientProfessionnel->setTelephone('0123456789');
        $clientProfessionnel->setTypeClient('professionnel');
        $clientProfessionnel->setCoefficientProfessionnel(2.0); // Coefficient pour un client professionnel
        $manager->persist($clientProfessionnel);

        // Vérification des champs obligatoires avant de persister
        if ($employe->getEmail() !== null && $employe->getPassword() !== null &&
            $clientParticulier->getEmail() !== null && $clientParticulier->getPassword() !== null &&
            $clientProfessionnel->getEmail() !== null && $clientProfessionnel->getPassword() !== null) {
            $manager->flush();
        } else {
            throw new \Exception('Les champs obligatoires ne sont pas définis.');
        }
    }
}

