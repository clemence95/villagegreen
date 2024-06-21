<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Commande::class)]
    private ?Commande $id_commande = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date_facture = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montant_total = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $statut_paiement = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    private ?Adresse $id_adresse_facturation = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->id_commande;
    }

    public function setIdCommande(?Commande $id_commande): self
    {
        $this->id_commande = $id_commande;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->date_facture;
    }

    public function setDateFacture(\DateTimeInterface $date_facture): self
    {
        $this->date_facture = $date_facture;

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

    public function getStatutPaiement(): ?string
    {
        return $this->statut_paiement;
    }

    public function setStatutPaiement(string $statut_paiement): self
    {
        $this->statut_paiement = $statut_paiement;

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
}
