<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Client")
 */
class Client
{
    /**
     * @ORM\Column(type="INT")
     */
    private $Id_Client;

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
    private $Type;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Adresse_livraison;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Adresse_facturation;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Coefficient;

    /**
     * @ORM\Column(type="NUMERIC(10, 0)")
     */
    private $Reduction;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $Reference;

    /**
     * @ORM\Column(type="VARCHAR(255)")
     */
    private $email;

}
