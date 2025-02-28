<?php

namespace App\Entity;

use App\Repository\AnalyseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ForeignKey;
use App\Entity\User;


#[ORM\Entity(repositoryClass: AnalyseRepository::class)]
class Analyse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idanalyse = null;

    #[ORM\Column(name: 'type_e', length: 255)]
    #[Assert\NotBlank(message: "Le choix est obligatoire")]
    #[Assert\Choice(
        choices: ["sol", "eau", "plante", "animal"],
        message: "Veuillez choisir une option valide"
    )]
    private ?string $typeE = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le résultat est obligatoire")]
    #[Assert\Length(
        min: 10,
        max: 100,
        minMessage: "La Reultat doit contenir au moins {{ limit }} caractères.",
        maxMessage: "La Resultat ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $result = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de réalisation est obligatoire")]
    private ?\DateTimeInterface $date_performed = null;

    


    #[ORM\ManyToOne(targetEntity: Echantillon::class, inversedBy: 'analyses')]
    #[ORM\JoinColumn(
    name: 'id_e', 
    referencedColumnName: 'id_e', 
    onDelete: 'CASCADE'
    )]
    private ?Echantillon $echantillon = null;
    
    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    private ?User $IdUser;

    // Getters and setters
    public function getIdanalyse(): ?int
    {
        return $this->idanalyse;
    }

    public function setIdanalyse(int $idanalyse): static
    {
        $this->idanalyse = $idanalyse;
        return $this;
    }

    public function getTypeE(): ?string
    {
        return $this->typeE;
    }

    public function setTypeE(string $typeE): static
    {
        $this->typeE = $typeE;
        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;
        return $this;
    }

    public function getDatePerformed(): ?\DateTimeInterface
    {
        return $this->date_performed;
    }

    public function setDatePerformed(\DateTimeInterface $date_performed): static
    {
        $this->date_performed = $date_performed;
        return $this;
    }

    public function getEchantillon(): ?Echantillon
    {
        return $this->echantillon;
    }

    public function setEchantillon(?Echantillon $echantillon): static
    {
        $this->echantillon = $echantillon;
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