<?php

// src/Entity/Commande.php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montant_total = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $reduction_supplementaire = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $mode_paiement = null;

    #[ORM\Column(type: 'text')]
    private ?string $information_reglement = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    private ?Adresse $id_adresse_facturation = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    private ?Adresse $id_adresse_livraison = null;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    private ?Client $id_client = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $bon_livraison = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $facture = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;
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
        return $this->montant_total;
    }

    public function setMontantTotal(float $montant_total): self
    {
        $this->montant_total = $montant_total;
        return $this;
    }

    public function getReductionSupplementaire(): ?float
    {
        return $this->reduction_supplementaire;
    }

    public function setReductionSupplementaire(?float $reduction_supplementaire): self
    {
        $this->reduction_supplementaire = $reduction_supplementaire;
        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->mode_paiement;
    }

    public function setModePaiement(string $mode_paiement): self
    {
        $this->mode_paiement = $mode_paiement;
        return $this;
    }

    public function getInformationReglement(): ?string
    {
        return $this->information_reglement;
    }

    public function setInformationReglement(string $information_reglement): self
    {
        $this->information_reglement = $information_reglement;
        return $this;
    }

    public function getIdAdresseFacturation(): ?Adresse
    {
        return $this->id_adresse_facturation;
    }

    public function setIdAdresseFacturation(?Adresse $id_adresse_facturation): self
    {
        $this->id_adresse_facturation = $id_adresse_facturation;
        return $this;
    }

    public function getIdAdresseLivraison(): ?Adresse
    {
        return $this->id_adresse_livraison;
    }

    public function setIdAdresseLivraison(?Adresse $id_adresse_livraison): self
    {
        $this->id_adresse_livraison = $id_adresse_livraison;
        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->id_client;
    }

    public function setIdClient(?Client $id_client): self
    {
        $this->id_client = $id_client;
        return $this;
    }

    public function getBonLivraison(): ?string
    {
        return $this->bon_livraison;
    }

    public function setBonLivraison(?string $bon_livraison): self
    {
        $this->bon_livraison = $bon_livraison;
        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;
        return $this;
    }
}
