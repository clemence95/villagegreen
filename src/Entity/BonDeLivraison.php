<?php

namespace App\Entity;

use App\Repository\BonDeLivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonDeLivraisonRepository::class)]
class BonDeLivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Commande::class)]
    private ?Commande $id_commande = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date_livraison = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    private ?Adresse $id_adresse_livraison = null;

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

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

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
}

