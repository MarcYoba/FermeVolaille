<?php

namespace App\Entity;

use App\Repository\FermesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FermesRepository::class)]
class Fermes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column(length: 255)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $capacite = null;

    #[ORM\Column]
    private ?int $nombreBatiments = null;

    #[ORM\ManyToOne(inversedBy: 'fermes')]
    private ?User $user = null;

    /**
     * @var Collection<int, Bandes>
     */
    #[ORM\OneToMany(targetEntity: Bandes::class, mappedBy: 'ferme')]
    private Collection $bandes;

    public function __construct()
    {
        $this->bandes = new ArrayCollection();
    }

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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getNombreBatiments(): ?int
    {
        return $this->nombreBatiments;
    }

    public function setNombreBatiments(int $nombreBatiments): static
    {
        $this->nombreBatiments = $nombreBatiments;

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
     * @return Collection<int, Bandes>
     */
    public function getBandes(): Collection
    {
        return $this->bandes;
    }

    public function addBande(Bandes $bande): static
    {
        if (!$this->bandes->contains($bande)) {
            $this->bandes->add($bande);
            $bande->setFerme($this);
        }

        return $this;
    }

    public function removeBande(Bandes $bande): static
    {
        if ($this->bandes->removeElement($bande)) {
            // set the owning side to null (unless already changed)
            if ($bande->getFerme() === $this) {
                $bande->setFerme(null);
            }
        }

        return $this;
    }
}
