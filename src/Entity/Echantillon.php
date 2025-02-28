<?php

namespace App\Entity;

use App\Repository\EchantillonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EchantillonRepository::class)]
class Echantillon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_e = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "CODE X est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 15,
        minMessage: "CODE X doit contenir au moins {{ limit }} caractères.",
        maxMessage: "CODE X ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $code_x = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le choix est obligatoire")]
    #[Assert\Choice(
        choices: ["sol", "eau", "plante", "animal"],
        message: "Veuillez choisir une option valide"
    )]
    private ?string $type_e = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $collection_date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'origine est obligatoire")]
    #[Assert\Length(
        min: 3,
        max: 15,
        minMessage: "L'origine' doit contenir au moins {{ limit }} caractères.",
        maxMessage: "L'origine' ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le choix est obligatoire")]
    #[Assert\Choice(
        choices: ["in pending", "in progress", "complete"],
        message: "Veuillez choisir une option valide"
    )]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Analyse::class, mappedBy: 'echantillon')]
    private Collection $analyses;

    public function __construct()
    {
        $this->analyses = new ArrayCollection();
    }

    // Getters and setters
    public function getIdE(): ?int
    {
        return $this->id_e;
    }

    public function setIdE(int $id_e): static
    {
        $this->id_e = $id_e;
        return $this;
    }

    public function getCodeX(): ?string
    {
        return $this->code_x;
    }

    public function setCodeX(string $code_x): static
    {
        $this->code_x = $code_x;
        return $this;
    }

    public function getTypeE(): ?string
    {
        return $this->type_e;
    }

    public function setTypeE(string $type_e): static
    {
        $this->type_e = $type_e;
        return $this;
    }

    public function getCollectionDate(): ?\DateTimeInterface
    {
        return $this->collection_date;
    }

    public function setCollectionDate(\DateTimeInterface $collection_date): static
    {
        $this->collection_date = $collection_date;
        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection<int, Analyse>
     */
    public function getAnalyses(): Collection
    {
        return $this->analyses;
    }

    public function addAnalysis(Analyse $analysis): static
    {
        if (!$this->analyses->contains($analysis)) {
            $this->analyses->add($analysis);
            $analysis->setEchantillon($this);
        }
        return $this;
    }

    public function removeAnalysis(Analyse $analysis): static
    {
        if ($this->analyses->removeElement($analysis)) {
            if ($analysis->getEchantillon() === $this) {
                $analysis->setEchantillon(null);
            }
        }
        return $this;
    }
}