<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $rue = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ville = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $code_postal = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $pays = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $numero_rue = null;

    #[ORM\OneToMany(mappedBy: 'adresseFacturation', targetEntity: Client::class)]
    private Collection $clients_facturation;

    #[ORM\OneToMany(mappedBy: 'adresseLivraison', targetEntity: Client::class)]
    private Collection $clients_livraison;

    public function __construct()
    {
        $this->clients_facturation = new ArrayCollection();
        $this->clients_livraison = new ArrayCollection();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numero_rue;
    }

    public function setNumeroRue(?string $numero_rue): self
    {
        $this->numero_rue = $numero_rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsFacturation(): Collection
    {
        return $this->clients_facturation;
    }

    public function addClientFacturation(Client $client): self
    {
        if (!$this->clients_facturation->contains($client)) {
            $this->clients_facturation[] = $client;
            $client->setAdresseFacturation($this);
        }

        return $this;
    }

    public function removeClientFacturation(Client $client): self
    {
        if ($this->clients_facturation->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getAdresseFacturation() === $this) {
                $client->setAdresseFacturation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsLivraison(): Collection
    {
        return $this->clients_livraison;
    }

    public function addClientLivraison(Client $client): self
    {
        if (!$this->clients_livraison->contains($client)) {
            $this->clients_livraison[] = $client;
            $client->setAdresseLivraison($this);
        }

        return $this;
    }

    public function removeClientLivraison(Client $client): self
    {
        if ($this->clients_livraison->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getAdresseLivraison() === $this) {
                $client->setAdresseLivraison(null);
            }
        }

        return $this;
    }
}



