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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'categorieParent')]
    private Collection $sousCategories;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'sousCategories')]
    #[ORM\JoinColumn(name: 'categorie_parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $categorieParent = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'sousCategorie')]
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

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getCategorieParent(): ?self
    {
        return $this->categorieParent;
    }

    public function setCategorieParent(?self $categorieParent): self
    {
        $this->categorieParent = $categorieParent;
        return $this;
    }

    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategorie(self $sousCategorie): self
    {
        if (!$this->sousCategories->contains($sousCategorie)) {
            $this->sousCategories->add($sousCategorie);
            $sousCategorie->setCategorieParent($this);
        }
        return $this;
    }

    public function removeSousCategorie(self $sousCategorie): self
    {
        if ($this->sousCategories->removeElement($sousCategorie)) {
            if ($sousCategorie->getCategorieParent() === $this) {
                $sousCategorie->setCategorieParent(null);
            }
        }
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getSousCategorie() === $this) {
                $produit->setSousCategorie(null);
            }
        }

        return $this;
    }
}






