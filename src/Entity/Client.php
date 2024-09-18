<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ClientRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'client')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', columns: ['email'])]
#[ApiResource(
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']],
    security: "is_granted('ROLE_ADMIN') or object == user" // Seulement pour admin ou le client concerné
)]
#[ApiFilter(SearchFilter::class, properties: [
    'reference_client' => 'exact'  // Recherche exacte par référence du client
])]
#[ApiFilter(OrderFilter::class, properties: ['reference_client', 'nom', 'prenom'], arguments: ['orderParameterName' => 'order'])]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['client:read', 'commande:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas un email valide.")]
    #[Groups(['client:read', 'client:write'])]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['client:read', 'client:write'])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['client:write'])]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 14, nullable: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $siret = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $entreprise = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $reference_client = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2,)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $coefficient = null;  // Champ pour le coefficient global

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $type_client = null;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    #[Groups(['client:read', 'client:write'])]
    private ?Employe $id_commercial = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(['client:write'])]
    private ?string $confirmationToken = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['client:read', 'client:write'])]
    private bool $isEmailConfirmed = false;

    private ?string $plainPassword = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Groups(['client:read'])]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    // Getters and Setters...
    
    #[Groups(['client:read'])]
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getReferenceClient(): ?string
    {
        return $this->reference_client;
    }

    public function setReferenceClient(string $reference_client): self
    {
        $this->reference_client = $reference_client;

        return $this;
    }

    public function getCoefficient(): ?string
    {
        return $this->coefficient;
    }

    public function setCoefficient(string $coefficient): self
    {
        $this->coefficient = $coefficient;

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

    public function getTypeClient(): ?string
    {
        return $this->type_client;
    }

    public function setTypeClient(string $type_client): self
    {
        $this->type_client = $type_client;

        return $this;
    }

    public function getIdCommercial(): ?Employe
    {
        return $this->id_commercial;
    }

    public function setIdCommercial(?Employe $id_commercial): self
    {
        $this->id_commercial = $id_commercial;

        return $this;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getIsEmailConfirmed(): ?bool
    {
        return $this->isEmailConfirmed;
    }

    public function setIsEmailConfirmed(bool $isEmailConfirmed): self
    {
        $this->isEmailConfirmed = $isEmailConfirmed;

        return $this;
    }
}






