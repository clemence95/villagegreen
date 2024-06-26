<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleCourt = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleLong = null;

    #[ORM\Column(length: 50)]
    private ?string $referenceFournisseur = null;

    #[ORM\Column(type: 'float')]
    private ?float $prixAchat = null;

    #[ORM\Column(type: 'float')]
    private ?float $prixVente = null;

    #[ORM\Column(type: 'integer')]
    private ?int $stock = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $actif = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $sousCategorie = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $idFournisseur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCourt(): ?string
    {
        return $this->libelleCourt;
    }

    public function setLibelleCourt(string $libelleCourt): self
    {
        $this->libelleCourt = $libelleCourt;
        return $this;
    }

    public function getLibelleLong(): ?string
    {
        return $this->libelleLong;
    }

    public function setLibelleLong(string $libelleLong): self
    {
        $this->libelleLong = $libelleLong;
        return $this;
    }

    public function getReferenceFournisseur(): ?string
    {
        return $this->referenceFournisseur;
    }

    public function setReferenceFournisseur(string $referenceFournisseur): self
    {
        $this->referenceFournisseur = $referenceFournisseur;
        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;
        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): self
    {
        $this->prixVente = $prixVente;
        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
        return $this;
    }

    public function getSousCategorie(): ?Categorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?Categorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function getIdFournisseur(): ?Fournisseur
    {
        return $this->idFournisseur;
    }

    public function setIdFournisseur(?Fournisseur $idFournisseur): self
    {
        $this->idFournisseur = $idFournisseur;
        return $this;
    }
}







