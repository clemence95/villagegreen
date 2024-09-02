<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['produit:read']],
    denormalizationContext: ['groups' => ['produit:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['produit:read', 'categorie:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write', 'categorie:read'])]
    private ?string $libelleCourt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $libelleLong = null;

    #[ORM\Column(length: 50)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $referenceFournisseur = null;

    #[ORM\Column(type: 'float')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?float $prixAchat = null;

    #[ORM\Column(type: 'float')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?float $prixVente = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?int $stock = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?bool $actif = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?Categorie $sousCategorie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $photo = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?Fournisseur $idFournisseur = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeProduit::class)]
    #[Groups(['produit:read'])]
    private Collection $commandeProduits;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }
}








