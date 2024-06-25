<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $libelle_court = null;

    #[ORM\Column(type: 'text')]
    private ?string $libelle_long = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $reference_fournisseur = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $prix_achat = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $prix_vente = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: 'integer')]
    private ?int $stock = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $actif = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    private ?Fournisseur $id_fournisseur = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    private ?Categorie $id_categorie = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    private ?Categorie $sousCategorie = null;  // Ajouter la relation pour la sous-catégorie

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCourt(): ?string
    {
        return $this->libelle_court;
    }

    public function setLibelleCourt(string $libelle_court): self
    {
        $this->libelle_court = $libelle_court;
        return $this;
    }

    public function getLibelleLong(): ?string
    {
        return $this->libelle_long;
    }

    public function setLibelleLong(string $libelle_long): self
    {
        $this->libelle_long = $libelle_long;
        return $this;
    }

    public function getReferenceFournisseur(): ?string
    {
        return $this->reference_fournisseur;
    }

    public function setReferenceFournisseur(string $reference_fournisseur): self
    {
        $this->reference_fournisseur = $reference_fournisseur;
        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prix_achat;
    }

    public function setPrixAchat(float $prix_achat): self
    {
        $this->prix_achat = $prix_achat;
        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prix_vente;
    }

    public function setPrixVente(float $prix_vente): self
    {
        $this->prix_vente = $prix_vente;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
        return $this;
    }

    public function getIdFournisseur(): ?Fournisseur
    {
        return $this->id_fournisseur;
    }

    public function setIdFournisseur(?Fournisseur $id_fournisseur): self
    {
        $this->id_fournisseur = $id_fournisseur;
        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;
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
}



