<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Commande")
 */
class Commande
{
    /**
     * @ORM\Column(type="int")
     */
    private $Id_Commande;

    public function getId_Commande(): int
    {
        return $this->Id_Commande;
    }

    public function setId_Commande(int $Id_Commande): self
    {
        $this->Id_Commande = $Id_Commande;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Statut;

    public function getStatut(): string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): self
    {
        $this->Statut = $Statut;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Mode_paiement;

    public function getMode_paiement(): string
    {
        return $this->Mode_paiement;
    }

    public function setMode_paiement(string $Mode_paiement): self
    {
        $this->Mode_paiement = $Mode_paiement;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Reduction_pro;

    public function getReduction_pro(): float
    {
        return $this->Reduction_pro;
    }

    public function setReduction_pro(float $Reduction_pro): self
    {
        $this->Reduction_pro = $Reduction_pro;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Total_HT;

    public function getTotal_HT(): float
    {
        return $this->Total_HT;
    }

    public function setTotal_HT(float $Total_HT): self
    {
        $this->Total_HT = $Total_HT;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Total_TTC;

    public function getTotal_TTC(): float
    {
        return $this->Total_TTC;
    }

    public function setTotal_TTC(float $Total_TTC): self
    {
        $this->Total_TTC = $Total_TTC;
        return $this;
    }

    /**
     * @ORM\Column(type="\DateTime")
     */
    private $Date_heure_commande;

    public function getDate_heure_commande(): \DateTime
    {
        return $this->Date_heure_commande;
    }

    public function setDate_heure_commande(\DateTime $Date_heure_commande): self
    {
        $this->Date_heure_commande = $Date_heure_commande;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Mode_differe;

    public function getMode_differe(): string
    {
        return $this->Mode_differe;
    }

    public function setMode_differe(string $Mode_differe): self
    {
        $this->Mode_differe = $Mode_differe;
        return $this;
    }

    /**
     * @ORM\Column(type="\DateTime")
     */
    private $Date_facturation;

    public function getDate_facturation(): \DateTime
    {
        return $this->Date_facturation;
    }

    public function setDate_facturation(\DateTime $Date_facturation): self
    {
        $this->Date_facturation = $Date_facturation;
        return $this;
    }

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

}
