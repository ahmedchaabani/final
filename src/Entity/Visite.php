<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank(message: "La date de visite est requise.")]
    #[Assert\Type(type: "\DateTimeInterface", message: "Format de date invalide.")]
    private ?\DateTimeInterface $dateVisite;

    #[ORM\Column(type: 'string', length: 255, nullable:false)]
    #[Assert\NotBlank(message: "Le diagnostic ne peut pas être vide.")]
    private ?string $diagnostic='';

    #[ORM\ManyToOne(targetEntity: Animal::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "L'animal est obligatoire.")]
    #[Assert\Valid]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(targetEntity: Veterinaire::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Le vétérinaire est obligatoire.")]
    #[Assert\Valid]
    private ?Veterinaire $veterinaire = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    private ?User $IdUser;


    public function __construct()
    {
        $this->dateVisite = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(?\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;
        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(?string $diagnostic): self
    {
        $this->diagnostic = $diagnostic;
        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function getVeterinaire(): ?Veterinaire
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?Veterinaire $veterinaire): self
    {
        $this->veterinaire = $veterinaire;
        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->IdUser;
    }

    public function setIdUser(User $IdUser): static
    {
        $this->IdUser = $IdUser;
        return $this;
    }
}
