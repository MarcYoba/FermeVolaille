<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    /**
     * @var Collection<int, Fermes>
     */
    #[ORM\OneToMany(targetEntity: Fermes::class, mappedBy: 'user')]
    private Collection $fermes;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'user')]
    private Collection $produits;

    /**
     * @var Collection<int, Magasin>
     */
    #[ORM\OneToMany(targetEntity: Magasin::class, mappedBy: 'user')]
    private Collection $magasins;

    /**
     * @var Collection<int, Achat>
     */
    #[ORM\OneToMany(targetEntity: Achat::class, mappedBy: 'relation')]
    private Collection $achats;

    /**
     * @var Collection<int, Bloc>
     */
    #[ORM\OneToMany(targetEntity: Bloc::class, mappedBy: 'user')]
    private Collection $blocs;

    /**
     * @var Collection<int, Batiments>
     */
    #[ORM\OneToMany(targetEntity: Batiments::class, mappedBy: 'user')]
    private Collection $batiments;

    /**
     * @var Collection<int, MagasinDedier>
     */
    #[ORM\OneToMany(targetEntity: MagasinDedier::class, mappedBy: 'user')]
    private Collection $magasinDediers;

    public function __construct()
    {
        $this->fermes = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->magasins = new ArrayCollection();
        $this->achats = new ArrayCollection();
        $this->blocs = new ArrayCollection();
        $this->batiments = new ArrayCollection();
        $this->magasinDediers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Fermes>
     */
    public function getFermes(): Collection
    {
        return $this->fermes;
    }

    public function addFerme(Fermes $ferme): static
    {
        if (!$this->fermes->contains($ferme)) {
            $this->fermes->add($ferme);
            $ferme->setUser($this);
        }

        return $this;
    }

    public function removeFerme(Fermes $ferme): static
    {
        if ($this->fermes->removeElement($ferme)) {
            // set the owning side to null (unless already changed)
            if ($ferme->getUser() === $this) {
                $ferme->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setUser($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getUser() === $this) {
                $produit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Magasin>
     */
    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): static
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins->add($magasin);
            $magasin->setUser($this);
        }

        return $this;
    }

    public function removeMagasin(Magasin $magasin): static
    {
        if ($this->magasins->removeElement($magasin)) {
            // set the owning side to null (unless already changed)
            if ($magasin->getUser() === $this) {
                $magasin->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Achat>
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): static
    {
        if (!$this->achats->contains($achat)) {
            $this->achats->add($achat);
            $achat->setRelation($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): static
    {
        if ($this->achats->removeElement($achat)) {
            // set the owning side to null (unless already changed)
            if ($achat->getRelation() === $this) {
                $achat->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bloc>
     */
    public function getBlocs(): Collection
    {
        return $this->blocs;
    }

    public function addBloc(Bloc $bloc): static
    {
        if (!$this->blocs->contains($bloc)) {
            $this->blocs->add($bloc);
            $bloc->setUser($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getUser() === $this) {
                $bloc->setUser(null);
            }
        }

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
            $batiment->setUser($this);
        }

        return $this;
    }

    public function removeBatiment(Batiments $batiment): static
    {
        if ($this->batiments->removeElement($batiment)) {
            // set the owning side to null (unless already changed)
            if ($batiment->getUser() === $this) {
                $batiment->setUser(null);
            }
        }

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
            $magasinDedier->setUser($this);
        }

        return $this;
    }

    public function removeMagasinDedier(MagasinDedier $magasinDedier): static
    {
        if ($this->magasinDediers->removeElement($magasinDedier)) {
            // set the owning side to null (unless already changed)
            if ($magasinDedier->getUser() === $this) {
                $magasinDedier->setUser(null);
            }
        }

        return $this;
    }
}
