<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmployeRepository;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NOM', fields: ['nom'])]
#[ApiResource(
    normalizationContext: ['groups' => ['employe:read']],
    denormalizationContext: ['groups' => ['employe:write']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[ApiFilter(SearchFilter::class, properties: [
    'nom' => 'partial',  // Recherche partielle par nom
    'email' => 'partial' // Recherche partielle par email
])]
#[ApiFilter(OrderFilter::class, properties: ['nom', 'prenom', 'email'], arguments: ['orderParameterName' => 'order'])]
class Employe implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['employe:read', 'commande:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['employe:read', 'employe:write'])]
    private ?string $nom = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['employe:read', 'employe:write'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['employe:write'])]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['employe:read', 'employe:write'])]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['employe:read', 'employe:write'])]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['employe:read', 'employe:write'])]
    private ?string $telephone = null;

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->nom;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Assurez-vous que chaque utilisateur a au moins le rôle "ROLE_USER"
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si vous stockez des données temporaires sensibles, effacez-les ici
    }
}


