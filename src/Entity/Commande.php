<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['commande:read']],
    denormalizationContext: ['groups' => ['commande:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[ApiFilter(SearchFilter::class, properties: [
    'client.nom' => 'partial',  // Recherche partielle par nom de client
    'statut' => 'partial',  // Recherche partielle par statut
    'dateCommande' => 'exact',  // Recherche exacte par date
])]
#[ApiFilter(OrderFilter::class, properties: ['dateCommande', 'client.nom', 'montantTotal'], arguments: ['orderParameterName' => 'order'])]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['commande:read', 'commande:write'])]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $statut = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $montantTotal = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $reductionSupplementaire = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $modePaiement = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $informationReglement = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?Adresse $adresseFacturation = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?Adresse $adresseLivraison = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?Employe $employe = null;

    #[ORM\OneToMany(targetEntity: CommandeProduit::class, mappedBy: 'commande', cascade: ['persist', 'remove'])]
    #[Groups(['commande:read', 'commande:write'])]
    private Collection $commandeProduits;

    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'commande', cascade: ['persist', 'remove'])]
    #[Groups(['commande:read', 'commande:write'])]
    private Collection $documents;
    
    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    // Getters and Setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): self
    {
        $this->montantTotal = $montantTotal;
        return $this;
    }

    public function getReductionSupplementaire(): ?float
    {
        return $this->reductionSupplementaire;
    }

    public function setReductionSupplementaire(?float $reductionSupplementaire): self
    {
        $this->reductionSupplementaire = $reductionSupplementaire;
        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;
        return $this;
    }

    public function getInformationReglement(): ?string
    {
        return $this->informationReglement;
    }

    public function setInformationReglement(string $informationReglement): self
    {
        $this->informationReglement = $informationReglement;
        return $this;
    }

    public function getAdresseFacturation(): ?Adresse
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?Adresse $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;
        return $this;
    }

    public function getAdresseLivraison(): ?Adresse
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?Adresse $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;
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
            $commandeProduit->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getCommande() === $this) {
                $commandeProduit->setCommande(null);
            }
        }

        return $this;
    }

    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCommande($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCommande() === $this) {
                $document->setCommande(null);
            }
        }

        return $this;
    }
}
