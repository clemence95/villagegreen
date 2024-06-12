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
     * @ORM\Column(type="INT")
     */
    private $Id_Produit;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_BonLivraison;

    /**
     * @ORM\Column(type="INT")
     */
    private $quantite;

}
