<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['produit:read_minimal']],
    denormalizationContext: ['groups' => ['produit:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[ApiFilter(SearchFilter::class, properties: ['sousCategorie' => 'exact'])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['produit:read_minimal', 'produit:read', 'categorie:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['produit:read_minimal', 'produit:write', 'categorie:read'])]
    private ?string $libelleCourt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $libelleLong = null;

    #[ORM\Column(length: 50)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $referenceFournisseur = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero(message: 'Le prix d\'achat ne peut pas être négatif')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $prixAchat = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero(message: 'Le stock ne peut pas être négatif')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?int $stock = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['produit:read', 'produit:write'])]
    private ?bool $actif = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero(message: 'Le prix de vente ne peut pas être négatif')]
    private ?string $prixVente = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['produit:read_minimal', 'produit:write'])]
    #[MaxDepth(1)]
    private ?Categorie $sousCategorie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $photo = null;

    #[ORM\ManyToOne(targetEntity: Fournisseur::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['produit:read', 'produit:write'])]
    #[MaxDepth(1)]
    private ?Fournisseur $idFournisseur = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeProduit::class, fetch: 'LAZY')]
    #[Groups(['produit:read'])]
    #[MaxDepth(1)]
    private Collection $commandeProduits;

    // Constructeur pour initialiser les collections
    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

    // Méthode pour calculer le prix HT (Hors Taxes) en fonction du client
    public function calculerPrixVenteHT(Client $client): string
    {
        // Vérifier que le prix d'achat est défini
        if ($this->prixAchat === null) {
            throw new \Exception("Le prix d'achat doit être défini pour calculer le prix de vente HT.");
        }

        // Récupérer le coefficient du client
        $coefficient = $client->getCoefficient(); // Récupérer le coefficient depuis l'objet Client

        // Calcul du prix de vente HT
        $prixVente = bcmul($this->prixAchat, (string)$coefficient, 2);

        // Mettre à jour le prix de vente HT
        $this->setPrixVente($prixVente);

        return $prixVente;
    }

    // Méthode pour calculer le prix TTC en fonction du prix HT et de la TVA
    public function calculerPrixVenteTTC(Client $client, string $tauxTVA = '0.2'): string
    {
        // Calculer le prix HT en passant l'objet Client à la méthode calculerPrixVenteHT
        $prixVente = $this->calculerPrixVenteHT($client);

        // Calculer le prix TTC en appliquant la TVA
        $prixVenteTTC = bcmul($prixVente, (string)(1 + (float)$tauxTVA), 2);

        return $prixVenteTTC;
    }

    // Getters et Setters
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

    public function getPrixVente(): ?string
    {
        return $this->prixVente;
    }

    public function setPrixVente(string $prixVente): self
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

    public function getActif(): ?bool
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
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }
}
