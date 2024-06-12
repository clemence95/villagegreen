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
     * @ORM\Column(type="int")
     */
    private $Id_Fournisseur;

    public function getId_Fournisseur(): int
    {
        return $this->Id_Fournisseur;
    }

    public function setId_Fournisseur(int $Id_Fournisseur): self
    {
        $this->Id_Fournisseur = $Id_Fournisseur;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Nom;

    public function getNom(): string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Contact;

    public function getContact(): string
    {
        return $this->Contact;
    }

    public function setContact(string $Contact): self
    {
        $this->Contact = $Contact;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $telephone;

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

}
