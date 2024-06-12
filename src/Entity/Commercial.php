<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Commercial")
 */
class Commercial
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Commercial;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Nom;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $prenom;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $telephone;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $email;

    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Client;

}
