<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Fournisseur")
 */
class Fournisseur
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Fournisseur;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Nom;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Contact;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $telephone;

}
