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
     * @ORM\Column(type="int")
     */
    private $Id_Produit;

    public function getId_Produit(): int
    {
        return $this->Id_Produit;
    }

    public function setId_Produit(int $Id_Produit): self
    {
        $this->Id_Produit = $Id_Produit;
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
    private $Libelle_long;

    public function getLibelle_long(): string
    {
        return $this->Libelle_long;
    }

    public function setLibelle_long(string $Libelle_long): self
    {
        $this->Libelle_long = $Libelle_long;
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $Prix_achat_HT;

    public function getPrix_achat_HT(): float
    {
        return $this->Prix_achat_HT;
    }

    public function setPrix_achat_HT(float $Prix_achat_HT): self
    {
        $this->Prix_achat_HT = $Prix_achat_HT;
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

    /**
     * @ORM\Column(type="float")
     */
    private $stock;

    public function getStock(): float
    {
        return $this->stock;
    }

    public function setStock(float $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $Actif;

    public function getActif(): string
    {
        return $this->Actif;
    }

    public function setActif(string $Actif): self
    {
        $this->Actif = $Actif;
        return $this;
    }

    /**
     * @ORM\Column(type="int")
     */
    private $Id_Souscategorie;

    public function getId_Souscategorie(): int
    {
        return $this->Id_Souscategorie;
    }

    public function setId_Souscategorie(int $Id_Souscategorie): self
    {
        $this->Id_Souscategorie = $Id_Souscategorie;
        return $this;
    }

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

}
