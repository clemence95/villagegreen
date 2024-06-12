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
     * @ORM\Column(type="int")
     */
    private $Id_Commercial;

    public function getId_Commercial(): int
    {
        return $this->Id_Commercial;
    }

    public function setId_Commercial(int $Id_Commercial): self
    {
        $this->Id_Commercial = $Id_Commercial;
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
    private $prenom;

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
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

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @ORM\Column(type="int")
     */
    private $Id_Client;

    public function getId_Client(): int
    {
        return $this->Id_Client;
    }

    public function setId_Client(int $Id_Client): self
    {
        $this->Id_Client = $Id_Client;
        return $this;
    }

}
