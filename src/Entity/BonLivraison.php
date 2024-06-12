<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="BonLivraison")
 */
class BonLivraison
{
    /**
     * @ORM\Column(type="int")
     */
    private $Id_BonLivraison;

    public function getId_BonLivraison(): int
    {
        return $this->Id_BonLivraison;
    }

    public function setId_BonLivraison(int $Id_BonLivraison): self
    {
        $this->Id_BonLivraison = $Id_BonLivraison;
        return $this;
    }

    /**
     * @ORM\Column(type="\DateTime")
     */
    private $Date_livraison;

    public function getDate_livraison(): \DateTime
    {
        return $this->Date_livraison;
    }

    public function setDate_livraison(\DateTime $Date_livraison): self
    {
        $this->Date_livraison = $Date_livraison;
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
    private $Suivi_commande;

    public function getSuivi_commande(): string
    {
        return $this->Suivi_commande;
    }

    public function setSuivi_commande(string $Suivi_commande): self
    {
        $this->Suivi_commande = $Suivi_commande;
        return $this;
    }

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

}
