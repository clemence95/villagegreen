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

    #[ORM\Column(length: 255)]
    private ?string $libelleCourt = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleLong = null;

    #[ORM\Column(length: 255)]
    private ?string $referenceFournisseur = null;

    #[ORM\Column]
    private ?float $prixAchatHT = null;

    #[ORM\Column]
    private ?float $prixVente = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $actif = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class, inversedBy: 'produits')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'produits')]
    private ?Employe $gestionPar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCourt(): ?string
    {
        return $this->libelleCourt;
    }

    public function setLibelleCourt(string $libelleCourt): static
    {
        $this->libelleCourt = $libelleCourt;

        return $this;
    }

    public function getLibelleLong(): ?string
    {
        return $this->libelleLong;
    }

    public function setLibelleLong(string $libelleLong): static
    {
        $this->libelleLong = $libelleLong;

        return $this;
    }

    public function getReferenceFournisseur(): ?string
    {
        return $this->referenceFournisseur;
    }

    public function setReferenceFournisseur(string $referenceFournisseur): static
    {
        $this->referenceFournisseur = $referenceFournisseur;

        return $this;
    }

    public function getPrixAchatHT(): ?float
    {
        return $this->prixAchatHT;
    }

    public function setPrixAchatHT(float $prixAchatHT): static
    {
        $this->prixAchatHT = $prixAchatHT;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getGestionPar(): ?Employe
    {
        return $this->gestionPar;
    }

    public function setGestionPar(?Employe $gestionPar): static
    {
        $this->gestionPar = $gestionPar;

        return $this;
    }
}


