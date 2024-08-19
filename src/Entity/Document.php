<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DocumentRepository;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    const TYPE_BON_LIVRAISON = 'bon_livraison';
    const TYPE_FACTURE = 'facture';
    

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $fileName = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    // Getters et Setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
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
}
