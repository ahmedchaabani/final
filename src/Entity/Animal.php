<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'animal est requis.")]
    private ?string $nom='';
    #[ORM\Column]
    #[Assert\NotNull(message: "L'âge de l'animal est requis.")]
    #[Assert\Positive(message: "L'âge doit être un nombre positif.")]
    #[Assert\LessThan(40, message: "L'âge de l'animal ne peut pas dépasser 40 ans.")]
    private ?int $age;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type d'animal est requis.")]
    private ?string $type='';
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'espèce de l'animal est requise.")]
    private ?string $espece='';
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le traitement de l'animal est requise.")]
    private ?string $traitement='';
    private ?Veterinaire $veterinaire;
    
    private Collection $visites;

    public function __construct()
    {
        $this->visites = new ArrayCollection();
       
    }

    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(?string $espece): self
    {
        $this->espece = $espece;
        return $this;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(?string $traitement): self
    {
        $this->traitement = $traitement;
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
}
