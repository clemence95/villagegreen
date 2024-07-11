<?php

// src/Entity/Client.php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'client')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', columns: ['email'])]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 14, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $entreprise = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $reference_client = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $coefficientParticulier = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $coefficientProfessionnel = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $type_client = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'clients_facturation')]
    private ?Adresse $id_adresse_facturation = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'clients_livraison')]
    private ?Adresse $id_adresse_livraison = null;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    private ?Employe $id_commercial = null;

    private ?string $plainPassword = null;

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

    public function getCoefficientParticulier(): ?float
    {
        return $this->coefficientParticulier;
    }

    public function setCoefficientParticulier(?float $coefficientParticulier): self
    {
        $this->coefficientParticulier = $coefficientParticulier;

        return $this;
    }

    public function getCoefficientProfessionnel(): ?float
    {
        return $this->coefficientProfessionnel;
    }

    public function setCoefficientProfessionnel(?float $coefficientProfessionnel): self
    {
        $this->coefficientProfessionnel = $coefficientProfessionnel;

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

    public function getIdAdresseFacturation(): ?Adresse
    {
        return $this->id_adresse_facturation;
    }

    public function setIdAdresseFacturation(?Adresse $id_adresse_facturation): self
    {
        $this->id_adresse_facturation = $id_adresse_facturation;

        return $this;
    }

    public function getIdAdresseLivraison(): ?Adresse
    {
        return $this->id_adresse_livraison;
    }

    public function setIdAdresseLivraison(?Adresse $id_adresse_livraison): self
    {
        $this->id_adresse_livraison = $id_adresse_livraison;

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
}



