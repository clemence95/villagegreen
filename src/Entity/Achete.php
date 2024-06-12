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
     * @ORM\Column(type="INT")
     */
    private $Id_Produit;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Commande;

    /**
     * @ORM\Column(type="INT")
     */
    private $quantite;

}
