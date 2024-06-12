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
     * @ORM\Column(type="INT")
     */
    private $Id_BonLivraison;

    /**
     * @ORM\Column(type="DATE")
     */
    private $Date_livraison;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Statut;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Suivi_commande;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Commande;

}
