<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="souscategorie")
 */
class Souscategorie
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Souscategorie;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Libelle_court;

    /**
     * @ORM\Column(type="LONGBLOB")
     */
    private $Photo;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Categorie;

}
