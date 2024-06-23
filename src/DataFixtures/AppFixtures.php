<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Client;
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
        $client = new Client();
        
        $email = 'test@example.com';
        $password = 'password123';
        $nom = 'Doe';
        $prenom = 'John';
        $siret = '12345678901234';
        $entreprise = 'Acme Corp';
        $referenceClient = 'REF123456';
        $coefficient = 1.5;
        $telephone = '0123456789';
        $typeClient = 'standard';

        $client->setEmail($email);
        $client->setRoles(['ROLE_USER']);
        $client->setPassword($this->passwordHasher->hashPassword($client, $password));
        $client->setNom($nom);
        $client->setPrenom($prenom);
        $client->setSiret($siret);
        $client->setEntreprise($entreprise);
        $client->setReferenceClient($referenceClient);
        $client->setCoefficient($coefficient);
        $client->setTelephone($telephone);
        $client->setTypeClient($typeClient);
        
        // Vous pouvez définir les adresses et le commercial ici si nécessaire
        // $client->setIdAdresseFacturation($adresseFacturation);
        // $client->setIdAdresseLivraison($adresseLivraison);
        // $client->setIdCommercial($commercial);

        // Vérification des champs obligatoires avant de persister
        if ($client->getEmail() !== null && $client->getPassword() !== null) {
            $manager->persist($client);
            $manager->flush();
        } else {
            throw new \Exception('Les champs obligatoires ne sont pas définis.');
        }
    }
}




