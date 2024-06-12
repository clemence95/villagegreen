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
     * @ORM\Column(type="int")
     */
    private $Id_Categorie;

    public function getId_Categorie(): int
    {
        return $this->Id_Categorie;
    }

    public function setId_Categorie(int $Id_Categorie): self
    {
        $this->Id_Categorie = $Id_Categorie;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Libelle_court;

    public function getLibelle_court(): string
    {
        return $this->Libelle_court;
    }

    public function setLibelle_court(string $Libelle_court): self
    {
        $this->Libelle_court = $Libelle_court;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Photo;

    public function getPhoto(): string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): self
    {
        $this->Photo = $Photo;
        return $this;
    }

}
