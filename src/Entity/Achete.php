<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="achete")
 */
class Achete
{
    /**
     * @ORM\Column(type="int")
     */
    private $Id_Produit;

    public function getId_Produit(): int
    {
        return $this->Id_Produit;
    }

    public function setId_Produit(int $Id_Produit): self
    {
        $this->Id_Produit = $Id_Produit;
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

    /**
     * @ORM\Column(type="int")
     */
    private $quantite;

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

}
