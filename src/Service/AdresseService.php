<?php

// src/Service/AdresseService.php
namespace App\Service;

use App\Entity\Adresse;
use Doctrine\ORM\EntityManagerInterface;

class AdresseService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOrCreateAdresse(Adresse $adresse): Adresse
    {
        $existingAdresse = $this->entityManager->getRepository(Adresse::class)->findOneBy([
            'rue' => $adresse->getRue(),
            'code_postal' => $adresse->getCodePostal(),
            'ville' => $adresse->getVille(),
            'pays' => $adresse->getPays(),
        ]);

        if ($existingAdresse) {
            return $existingAdresse;
        }

        $this->entityManager->persist($adresse);
        $this->entityManager->flush();

        return $adresse;
    }
}


