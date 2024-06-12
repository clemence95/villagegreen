<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Client")
 */
class Client
{
    /**
     * @ORM\Column(type="int")
     */
    private $Id_Client;

    public function getId_Client(): int
    {
        return $this->Id_Client;
    }

    public function setId_Client(int $Id_Client): self
    {
        $this->Id_Client = $Id_Client;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Nom;

    public function getNom(): string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $prenom;

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $telephone;

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Type;

    public function getType(): string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Adresse_livraison;

    public function getAdresse_livraison(): string
    {
        return $this->Adresse_livraison;
    }

    public function setAdresse_livraison(string $Adresse_livraison): self
    {
        $this->Adresse_livraison = $Adresse_livraison;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Adresse_facturation;

    public function getAdresse_facturation(): string
    {
        return $this->Adresse_facturation;
    }

    public function setAdresse_facturation(string $Adresse_facturation): self
    {
        $this->Adresse_facturation = $Adresse_facturation;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Coefficient;

    public function getCoefficient(): float
    {
        return $this->Coefficient;
    }

    public function setCoefficient(float $Coefficient): self
    {
        $this->Coefficient = $Coefficient;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Reduction;

    public function getReduction(): float
    {
        return $this->Reduction;
    }

    public function setReduction(float $Reduction): self
    {
        $this->Reduction = $Reduction;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Reference;

    public function getReference(): string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): self
    {
        $this->Reference = $Reference;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

}
