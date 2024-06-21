<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom_entreprise = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $contact = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 14)]
    private ?string $siret = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $importateur = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $fabricant = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    private ?Adresse $id_adresse = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getImportateur(): ?bool
    {
        return $this->importateur;
    }

    public function setImportateur(bool $importateur): self
    {
        $this->importateur = $importateur;

        return $this;
    }

    public function getFabricant(): ?bool
    {
        return $this->fabricant;
    }

    public function setFabricant(bool $fabricant): self
    {
        $this->fabricant = $fabricant;

        return $this;
    }

    public function getIdAdresse(): ?Adresse
    {
        return $this->id_adresse;
    }

    public function setIdAdresse(?Adresse $id_adresse): self
    {
        $this->id_adresse = $id_adresse;

        return $this;
    }
}

