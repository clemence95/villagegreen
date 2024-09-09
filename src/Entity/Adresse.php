<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['commande:read']],
    denormalizationContext: ['groups' => ['commande:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $rue = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $ville = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $code_postal = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $pays = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[Groups(['commande:read', 'commande:write'])]
    private ?string $numero_rue = null;

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

}



