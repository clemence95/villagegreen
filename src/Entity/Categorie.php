<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 */
class Categorie
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Categorie;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Libelle_court;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Photo;

}
