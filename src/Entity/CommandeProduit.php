<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommandeProduitRepository;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['commande_produit:read']],
    denormalizationContext: ['groups' => ['commande_produit:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[ApiFilter(SearchFilter::class, properties: [
    'commande.id' => 'exact',  // Filtre exact sur l'ID de la commande
    'produit.id' => 'exact',   // Filtre exact sur l'ID du produit
])]
#[ApiFilter(OrderFilter::class, properties: ['commande.id', 'produit.id', 'quantite'], arguments: ['orderParameterName' => 'order'])]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande_produit:read', 'commande:read', 'produit:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commande_produit:read', 'commande_produit:write', 'commande:read'])]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commande_produit:read', 'commande_produit:write', 'produit:read'])]
    private ?Produit $produit = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['commande_produit:read', 'commande_produit:write'])]
    private ?string $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

}

