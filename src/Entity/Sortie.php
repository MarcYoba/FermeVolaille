<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantiteSortie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?Lot $lot = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?Traitement $Traitement = null;

    /**
     * @var Collection<int, CoutSanitaire>
     */
    #[ORM\OneToMany(targetEntity: CoutSanitaire::class, mappedBy: 'sortie')]
    private Collection $coutSanitaires;

    public function __construct()
    {
        $this->coutSanitaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(?Lot $lot): static
    {
        $this->lot = $lot;

        return $this;
    }

    public function getTraitement(): ?Traitement
    {
        return $this->Traitement;
    }

    public function setTraitement(?Traitement $Traitement): static
    {
        $this->Traitement = $Traitement;

        return $this;
    }

    /**
     * @return Collection<int, CoutSanitaire>
     */
    public function getCoutSanitaires(): Collection
    {
        return $this->coutSanitaires;
    }

    public function addCoutSanitaire(CoutSanitaire $coutSanitaire): static
    {
        if (!$this->coutSanitaires->contains($coutSanitaire)) {
            $this->coutSanitaires->add($coutSanitaire);
            $coutSanitaire->setSortie($this);
        }

        return $this;
    }

    public function removeCoutSanitaire(CoutSanitaire $coutSanitaire): static
    {
        if ($this->coutSanitaires->removeElement($coutSanitaire)) {
            // set the owning side to null (unless already changed)
            if ($coutSanitaire->getSortie() === $this) {
                $coutSanitaire->setSortie(null);
            }
        }

        return $this;
    }
}
