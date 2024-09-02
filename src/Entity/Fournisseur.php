<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['fournisseur:read']],
    denormalizationContext: ['groups' => ['fournisseur:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['fournisseur:read', 'produit:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['fournisseur:read', 'fournisseur:write', 'produit:read'])]
    private ?string $nomEntreprise = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?string $contact = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 14)]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?string $siret = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?bool $importateur = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?bool $fabricant = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    #[Groups(['fournisseur:read', 'fournisseur:write'])]
    private ?Adresse $idAdresse = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;
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
        return $this->idAdresse;
    }

    public function setIdAdresse(?Adresse $idAdresse): self
    {
        $this->idAdresse = $idAdresse;
        return $this;
    }
}


