<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "L'email est obligatoire")]
    #[Assert\Email(message: "Format d'email invalide")]
    #[Assert\Length(
        max: 180,
        maxMessage: "L'email ne peut dépasser {{ limit }} caractères"
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Minimum {{ limit }} caractères",
        maxMessage: "Maximum {{ limit }} caractères"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\- ]+$/",
        message: "Caractères spéciaux interdits"
    )]
    private ?string $nom = null; 

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Minimum {{ limit }} caractères",
        maxMessage: "Maximum {{ limit }} caractères"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\- ]+$/",
        message: "Caractères spéciaux interdits"
    )]
    private ?string $prenom = null; 
    #[Assert\NotBlank(message: "Le telephone est obligatoire")]
    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Length(
        min: 8,
        max: 8,
        exactMessage: "Le numéro doit contenir 8 chiffres"
    )]
    #[Assert\Regex(
        pattern: "/^[0-9]+$/",
        message: "Uniquement des chiffres"
    )]
    #[Assert\Type(
        type: "string",
        message: "Doit être une chaîne de caractères"
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]

    #[Assert\NotBlank(message: "Ladresse est obligatoire")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Maximum {{ limit }} caractères"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9À-ÿ\-\s,]+$/",
        message: "Caractères spéciaux interdits"
    )]
    #[Assert\Type(
        type: "string",
        message: "Doit être une chaîne de caractères"
    )]
    private ?string $adresse = null;

    #[ORM\Column(type: 'datetime', options: ["default" => "CURRENT_TIMESTAMP"])]
private ?\DateTimeInterface $dateInscription = null;

  
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
  
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $profilePicture = null;

    // Getter et setter pour profilePicture
    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;
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

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
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
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }
    public function getDateInscription(): ?\DateTimeInterface
{
    return $this->dateInscription;
}

public function setDateInscription(?\DateTimeInterface $dateInscription): static
{
    $this->dateInscription = $dateInscription ?? new \DateTime();
    return $this;
}

}
