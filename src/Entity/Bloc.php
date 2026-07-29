<?php

namespace App\Entity;

use App\Repository\BlocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlocRepository::class)]
class Bloc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $batiment = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    #[ORM\ManyToOne(inversedBy: 'blocs')]
    private ?User $user = null;

    /**
     * @var Collection<int, Batiments>
     */
    #[ORM\OneToMany(targetEntity: Batiments::class, mappedBy: 'bloc')]
    private Collection $batiments;

    public function __construct()
    {
        $this->batiments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatiment(): ?int
    {
        return $this->batiment;
    }

    public function setBatiment(int $batiment): static
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatetAt(): ?\DateTime
    {
        return $this->createtAt;
    }

    public function setCreatetAt(\DateTime $createtAt): static
    {
        $this->createtAt = $createtAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Batiments>
     */
    public function getBatiments(): Collection
    {
        return $this->batiments;
    }

    public function addBatiment(Batiments $batiment): static
    {
        if (!$this->batiments->contains($batiment)) {
            $this->batiments->add($batiment);
            $batiment->setBloc($this);
        }

        return $this;
    }

    public function removeBatiment(Batiments $batiment): static
    {
        if ($this->batiments->removeElement($batiment)) {
            // set the owning side to null (unless already changed)
            if ($batiment->getBloc() === $this) {
                $batiment->setBloc(null);
            }
        }

        return $this;
    }
}
