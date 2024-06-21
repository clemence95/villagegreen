<?php

namespace App\Entity;

use App\Repository\CoefficientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoefficientRepository::class)]
class Coefficient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $type_client = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $coefficient = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeClient(): ?string
    {
        return $this->type_client;
    }

    public function setTypeClient(string $type_client): self
    {
        $this->type_client = $type_client;

        return $this;
    }

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(float $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }
}

