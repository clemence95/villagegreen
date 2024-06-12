<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="livre")
 */
class Livre
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
