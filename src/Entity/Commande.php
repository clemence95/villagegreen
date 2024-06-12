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
     * @ORM\Column(type="INT")
     */
    private $Id_Commande;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Statut;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Mode_paiement;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Reduction_pro;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Total_HT;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Total_TTC;

    /**
     * @ORM\Column(type="DATETIME")
     */
    private $Date_heure_commande;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Mode_differe;

    /**
     * @ORM\Column(type="DATE")
     */
    private $Date_facturation;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Client;

}
