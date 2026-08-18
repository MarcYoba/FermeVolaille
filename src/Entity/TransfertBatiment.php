<?php

namespace App\Entity;

use App\Repository\TransfertBatimentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransfertBatimentRepository::class)]
class TransfertBatiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'transfertBatiments')]
    private ?Batiments $batimenta = null;

    #[ORM\ManyToOne(inversedBy: 'transfertBatiments')]
    private ?Batiments $batimentB = null;

    #[ORM\ManyToOne(inversedBy: 'transfertBatiments')]
    private ?Bloc $bloc = null;

    #[ORM\ManyToOne(inversedBy: 'transfertBatiments')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'transfertBatiments')]
    private ?Bandes $bandes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBatimenta(): ?Batiments
    {
        return $this->batimenta;
    }

    public function setBatimenta(?Batiments $batimenta): static
    {
        $this->batimenta = $batimenta;

        return $this;
    }

    public function getBatimentB(): ?Batiments
    {
        return $this->batimentB;
    }

    public function setBatimentB(?Batiments $batimentB): static
    {
        $this->batimentB = $batimentB;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBandes(): ?Bandes
    {
        return $this->bandes;
    }

    public function setBandes(?Bandes $bandes): static
    {
        $this->bandes = $bandes;

        return $this;
    }
}
