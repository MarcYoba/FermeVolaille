<?php

namespace App\Entity;

use App\Repository\BatimentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentsRepository::class)]
class Batiments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $surface = null;

    #[ORM\Column(length: 255)]
    private ?string $capacite = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateContruction = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    #[ORM\ManyToOne(inversedBy: 'batiments')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'batiments')]
    private ?Bloc $bloc = null;

    /**
     * @var Collection<int, MagasinDedier>
     */
    #[ORM\OneToMany(targetEntity: MagasinDedier::class, mappedBy: 'batiment')]
    private Collection $magasinDediers;

    /**
     * @var Collection<int, Bandes>
     */
    #[ORM\OneToMany(targetEntity: Bandes::class, mappedBy: 'batiments')]
    private Collection $bandes;

    /**
     * @var Collection<int, TransfertBatiment>
     */
    #[ORM\OneToMany(targetEntity: TransfertBatiment::class, mappedBy: 'batimenta')]
    private Collection $transfertBatiments;

    public function __construct()
    {
        $this->magasinDediers = new ArrayCollection();
        $this->bandes = new ArrayCollection();
        $this->transfertBatiments = new ArrayCollection();
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

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): static
    {
        $this->surface = $surface;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDateContruction(): ?\DateTime
    {
        return $this->dateContruction;
    }

    public function setDateContruction(\DateTime $dateContruction): static
    {
        $this->dateContruction = $dateContruction;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

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

    public function getBloc(): ?Bloc
    {
        return $this->bloc;
    }

    public function setBloc(?Bloc $bloc): static
    {
        $this->bloc = $bloc;

        return $this;
    }

    /**
     * @return Collection<int, MagasinDedier>
     */
    public function getMagasinDediers(): Collection
    {
        return $this->magasinDediers;
    }

    public function addMagasinDedier(MagasinDedier $magasinDedier): static
    {
        if (!$this->magasinDediers->contains($magasinDedier)) {
            $this->magasinDediers->add($magasinDedier);
            $magasinDedier->setBatiment($this);
        }

        return $this;
    }

    public function removeMagasinDedier(MagasinDedier $magasinDedier): static
    {
        if ($this->magasinDediers->removeElement($magasinDedier)) {
            // set the owning side to null (unless already changed)
            if ($magasinDedier->getBatiment() === $this) {
                $magasinDedier->setBatiment(null);
            }
        }

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
            $bande->setBatiments($this);
        }

        return $this;
    }

    public function removeBande(Bandes $bande): static
    {
        if ($this->bandes->removeElement($bande)) {
            // set the owning side to null (unless already changed)
            if ($bande->getBatiments() === $this) {
                $bande->setBatiments(null);
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
            $transfertBatiment->setBatimenta($this);
        }

        return $this;
    }

    public function removeTransfertBatiment(TransfertBatiment $transfertBatiment): static
    {
        if ($this->transfertBatiments->removeElement($transfertBatiment)) {
            // set the owning side to null (unless already changed)
            if ($transfertBatiment->getBatimenta() === $this) {
                $transfertBatiment->setBatimenta(null);
            }
        }

        return $this;
    }
}
