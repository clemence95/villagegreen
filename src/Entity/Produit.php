<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="produit")
 */
class Produit
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Produit;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Libelle_court;

    /**
     * @ORM\Column(type="LONGTEXT")
     */
    private $Libelle_long;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Prix_achat_HT;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Photo;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $stock;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Actif;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Souscategorie;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Fournisseur;

}
