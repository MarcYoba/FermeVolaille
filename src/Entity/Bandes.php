<?php

namespace App\Entity;

use App\Repository\BandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandesRepository::class)]
class Bandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\ManyToOne(inversedBy: 'bandes')]
    private ?Fermes $ferme = null;

    #[ORM\ManyToOne(inversedBy: 'bandes')]
    private ?Batiments $batiments = null;

    #[ORM\Column(length: 255)]
    private ?string $souche = null;

    #[ORM\Column(length: 255)]
    private ?string $fournisseur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateMisePlace = null;

    #[ORM\Column(length: 255)]
    private ?string $poussins = null;

    #[ORM\Column(length: 255)]
    private ?string $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $poids = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateAbattage = null;

    #[ORM\ManyToOne(inversedBy: 'bandes')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    /**
     * @var Collection<int, Suivi>
     */
    #[ORM\OneToMany(targetEntity: Suivi::class, mappedBy: 'bande')]
    private Collection $suivis;

    /**
     * @var Collection<int, Vaccination>
     */
    #[ORM\OneToMany(targetEntity: Vaccination::class, mappedBy: 'bande')]
    private Collection $vaccinations;

    /**
     * @var Collection<int, TransfertBatiment>
     */
    #[ORM\OneToMany(targetEntity: TransfertBatiment::class, mappedBy: 'bandes')]
    private Collection $transfertBatiments;

    public function __construct()
    {
        $this->suivis = new ArrayCollection();
        $this->vaccinations = new ArrayCollection();
        $this->transfertBatiments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getFerme(): ?Fermes
    {
        return $this->ferme;
    }

    public function setFerme(?Fermes $ferme): static
    {
        $this->ferme = $ferme;

        return $this;
    }

    public function getBatiments(): ?Batiments
    {
        return $this->batiments;
    }

    public function setBatiments(?Batiments $batiments): static
    {
        $this->batiments = $batiments;

        return $this;
    }

    public function getSouche(): ?string
    {
        return $this->souche;
    }

    public function setSouche(string $souche): static
    {
        $this->souche = $souche;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getDateMisePlace(): ?\DateTime
    {
        return $this->dateMisePlace;
    }

    public function setDateMisePlace(\DateTime $dateMisePlace): static
    {
        $this->dateMisePlace = $dateMisePlace;

        return $this;
    }

    public function getPoussins(): ?string
    {
        return $this->poussins;
    }

    public function setPoussins(string $poussins): static
    {
        $this->poussins = $poussins;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDateAbattage(): ?\DateTime
    {
        return $this->dateAbattage;
    }

    public function setDateAbattage(\DateTime $dateAbattage): static
    {
        $this->dateAbattage = $dateAbattage;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Suivi>
     */
    public function getSuivis(): Collection
    {
        return $this->suivis;
    }

    public function addSuivi(Suivi $suivi): static
    {
        if (!$this->suivis->contains($suivi)) {
            $this->suivis->add($suivi);
            $suivi->setBande($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): static
    {
        if ($this->suivis->removeElement($suivi)) {
            // set the owning side to null (unless already changed)
            if ($suivi->getBande() === $this) {
                $suivi->setBande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vaccination>
     */
    public function getVaccinations(): Collection
    {
        return $this->vaccinations;
    }

    public function addVaccination(Vaccination $vaccination): static
    {
        if (!$this->vaccinations->contains($vaccination)) {
            $this->vaccinations->add($vaccination);
            $vaccination->setBande($this);
        }

        return $this;
    }

    public function removeVaccination(Vaccination $vaccination): static
    {
        if ($this->vaccinations->removeElement($vaccination)) {
            // set the owning side to null (unless already changed)
            if ($vaccination->getBande() === $this) {
                $vaccination->setBande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TransfertBatiment>
     */
    public function getTransfertBatiments(): Collection
    {
        return $this->transfertBatiments;
    }

    public function addTransfertBatiment(TransfertBatiment $transfertBatiment): static
    {
        if (!$this->transfertBatiments->contains($transfertBatiment)) {
            $this->transfertBatiments->add($transfertBatiment);
            $transfertBatiment->setBandes($this);
        }

        return $this;
    }

    public function removeTransfertBatiment(TransfertBatiment $transfertBatiment): static
    {
        if ($this->transfertBatiments->removeElement($transfertBatiment)) {
            // set the owning side to null (unless already changed)
            if ($transfertBatiment->getBandes() === $this) {
                $transfertBatiment->setBandes(null);
            }
        }

        return $this;
    }
}
