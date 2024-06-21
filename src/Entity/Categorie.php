<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?Categorie $id_sousCategorie = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIdSousCategorie(): ?self
    {
        return $this->id_sousCategorie;
    }

    public function setIdSousCategorie(?self $id_sousCategorie): self
    {
        $this->id_sousCategorie = $id_sousCategorie;

        return $this;
    }
}

