<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'sousCategories')]
    private ?self $categorie = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: self::class)]
    private Collection $sousCategories;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Produit::class)]
    private Collection $produits;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?self
    {
        return $this->categorie;
    }

    public function setCategorie(?self $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategorie(self $sousCategorie): static
    {
        if (!$this->sousCategories->contains($sousCategorie)) {
            $this->sousCategories->add($sousCategorie);
            $sousCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeSousCategorie(self $sousCategorie): static
    {
        if ($this->sousCategories->removeElement($sousCategorie)) {
            if ($sousCategorie->getCategorie() === $this) {
                $sousCategorie->setCategorie(null);
            }
        }

        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }
}

