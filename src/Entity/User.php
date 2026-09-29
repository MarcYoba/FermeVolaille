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

    /**
     * @var Collection<int, Bandes>
     */
    #[ORM\OneToMany(targetEntity: Bandes::class, mappedBy: 'user')]
    private Collection $bandes;

    /**
     * @var Collection<int, Suivi>
     */
    #[ORM\OneToMany(targetEntity: Suivi::class, mappedBy: 'user')]
    private Collection $suivis;

    /**
     * @var Collection<int, Pesees>
     */
    #[ORM\OneToMany(targetEntity: Pesees::class, mappedBy: 'user')]
    private Collection $pesees;

    /**
     * @var Collection<int, Aliment>
     */
    #[ORM\OneToMany(targetEntity: Aliment::class, mappedBy: 'user')]
    private Collection $aliments;

    /**
     * @var Collection<int, MouvementStock>
     */
    #[ORM\OneToMany(targetEntity: MouvementStock::class, mappedBy: 'user')]
    private Collection $mouvementStocks;

    /**
     * @var Collection<int, Fournisseur>
     */
    #[ORM\OneToMany(targetEntity: Fournisseur::class, mappedBy: 'user')]
    private Collection $fournisseurs;

    /**
     * @var Collection<int, Entree>
     */
    #[ORM\OneToMany(targetEntity: Entree::class, mappedBy: 'user')]
    private Collection $entrees;

    /**
     * @var Collection<int, Lot>
     */
    #[ORM\OneToMany(targetEntity: Lot::class, mappedBy: 'user')]
    private Collection $lots;

    /**
     * @var Collection<int, Medicament>
     */
    #[ORM\OneToMany(targetEntity: Medicament::class, mappedBy: 'user')]
    private Collection $medicaments;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'user')]
    private Collection $sorties;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\OneToMany(targetEntity: Traitement::class, mappedBy: 'user')]
    private Collection $traitements;

    /**
     * @var Collection<int, CoutSanitaire>
     */
    #[ORM\OneToMany(targetEntity: CoutSanitaire::class, mappedBy: 'user')]
    private Collection $coutSanitaires;

    /**
     * @var Collection<int, Vaccination>
     */
    #[ORM\OneToMany(targetEntity: Vaccination::class, mappedBy: 'user')]
    private Collection $vaccinations;

    /**
     * @var Collection<int, TransfertBatiment>
     */
    #[ORM\OneToMany(targetEntity: TransfertBatiment::class, mappedBy: 'user')]
    private Collection $transfertBatiments;

    public function __construct()
    {
        $this->fermes = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->magasins = new ArrayCollection();
        $this->achats = new ArrayCollection();
        $this->blocs = new ArrayCollection();
        $this->batiments = new ArrayCollection();
        $this->magasinDediers = new ArrayCollection();
        $this->bandes = new ArrayCollection();
        $this->suivis = new ArrayCollection();
        $this->pesees = new ArrayCollection();
        $this->aliments = new ArrayCollection();
        $this->mouvementStocks = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->entrees = new ArrayCollection();
        $this->lots = new ArrayCollection();
        $this->medicaments = new ArrayCollection();
        $this->sorties = new ArrayCollection();
        $this->traitements = new ArrayCollection();
        $this->coutSanitaires = new ArrayCollection();
        $this->vaccinations = new ArrayCollection();
        $this->transfertBatiments = new ArrayCollection();
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
            $bande->setUser($this);
        }

        return $this;
    }

    public function removeBande(Bandes $bande): static
    {
        if ($this->bandes->removeElement($bande)) {
            // set the owning side to null (unless already changed)
            if ($bande->getUser() === $this) {
                $bande->setUser(null);
            }
        }

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
            $suivi->setUser($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): static
    {
        if ($this->suivis->removeElement($suivi)) {
            // set the owning side to null (unless already changed)
            if ($suivi->getUser() === $this) {
                $suivi->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pesees>
     */
    public function getPesees(): Collection
    {
        return $this->pesees;
    }

    public function addPesee(Pesees $pesee): static
    {
        if (!$this->pesees->contains($pesee)) {
            $this->pesees->add($pesee);
            $pesee->setUser($this);
        }

        return $this;
    }

    public function removePesee(Pesees $pesee): static
    {
        if ($this->pesees->removeElement($pesee)) {
            // set the owning side to null (unless already changed)
            if ($pesee->getUser() === $this) {
                $pesee->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Aliment>
     */
    public function getAliments(): Collection
    {
        return $this->aliments;
    }

    public function addAliment(Aliment $aliment): static
    {
        if (!$this->aliments->contains($aliment)) {
            $this->aliments->add($aliment);
            $aliment->setUser($this);
        }

        return $this;
    }

    public function removeAliment(Aliment $aliment): static
    {
        if ($this->aliments->removeElement($aliment)) {
            // set the owning side to null (unless already changed)
            if ($aliment->getUser() === $this) {
                $aliment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MouvementStock>
     */
    public function getMouvementStocks(): Collection
    {
        return $this->mouvementStocks;
    }

    public function addMouvementStock(MouvementStock $mouvementStock): static
    {
        if (!$this->mouvementStocks->contains($mouvementStock)) {
            $this->mouvementStocks->add($mouvementStock);
            $mouvementStock->setUser($this);
        }

        return $this;
    }

    public function removeMouvementStock(MouvementStock $mouvementStock): static
    {
        if ($this->mouvementStocks->removeElement($mouvementStock)) {
            // set the owning side to null (unless already changed)
            if ($mouvementStock->getUser() === $this) {
                $mouvementStock->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): static
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->setUser($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): static
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            // set the owning side to null (unless already changed)
            if ($fournisseur->getUser() === $this) {
                $fournisseur->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entree>
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(Entree $entree): static
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees->add($entree);
            $entree->setUser($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): static
    {
        if ($this->entrees->removeElement($entree)) {
            // set the owning side to null (unless already changed)
            if ($entree->getUser() === $this) {
                $entree->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): static
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
            $lot->setUser($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): static
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getUser() === $this) {
                $lot->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicaments(): Collection
    {
        return $this->medicaments;
    }

    public function addMedicament(Medicament $medicament): static
    {
        if (!$this->medicaments->contains($medicament)) {
            $this->medicaments->add($medicament);
            $medicament->setUser($this);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): static
    {
        if ($this->medicaments->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getUser() === $this) {
                $medicament->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): static
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setUser($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getUser() === $this) {
                $sorty->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): static
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
            $traitement->setUser($this);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): static
    {
        if ($this->traitements->removeElement($traitement)) {
            // set the owning side to null (unless already changed)
            if ($traitement->getUser() === $this) {
                $traitement->setUser(null);
            }
        }

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
            $coutSanitaire->setUser($this);
        }

        return $this;
    }

    public function removeCoutSanitaire(CoutSanitaire $coutSanitaire): static
    {
        if ($this->coutSanitaires->removeElement($coutSanitaire)) {
            // set the owning side to null (unless already changed)
            if ($coutSanitaire->getUser() === $this) {
                $coutSanitaire->setUser(null);
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
            $vaccination->setUser($this);
        }

        return $this;
    }

    public function removeVaccination(Vaccination $vaccination): static
    {
        if ($this->vaccinations->removeElement($vaccination)) {
            // set the owning side to null (unless already changed)
            if ($vaccination->getUser() === $this) {
                $vaccination->setUser(null);
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
            $transfertBatiment->setUser($this);
        }

        return $this;
    }

    public function removeTransfertBatiment(TransfertBatiment $transfertBatiment): static
    {
        if ($this->transfertBatiments->removeElement($transfertBatiment)) {
            // set the owning side to null (unless already changed)
            if ($transfertBatiment->getUser() === $this) {
                $transfertBatiment->setUser(null);
            }
        }

        return $this;
    }
}
