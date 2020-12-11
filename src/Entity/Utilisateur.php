<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @ApiResource()
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;
    

    /**
     * @ORM\OneToMany(targetEntity=Realise::class, mappedBy="utilisateur")
     */
    private $realises;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="utilisateurs")
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Abonnements::class, inversedBy="utilisateurs")
     */
    private $abonnements;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="utilisateurs")
     */
    private $entreprise;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->testsrealise = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->abonnements = new ArrayCollection();
        $this->realises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->addUtilisateur($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->removeElement($test)) {
            $test->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTestsrealise(): Collection
    {
        return $this->testsrealise;
    }

    public function addTestsrealise(Test $testsrealise): self
    {
        if (!$this->testsrealise->contains($testsrealise)) {
            $this->testsrealise[] = $testsrealise;
            $testsrealise->addRealiseTest($this);
        }

        return $this;
    }

    public function removeTestsrealise(Test $testsrealise): self
    {
        if ($this->testsrealise->removeElement($testsrealise)) {
            $testsrealise->removeRealiseTest($this);
        }

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUtilisateur() === $this) {
                $role->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Abonnements[]
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnements $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements[] = $abonnement;
            $abonnement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnements $abonnement): self
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getUtilisateur() === $this) {
                $abonnement->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Realise[]
     */
    public function getRealises(): Collection
    {
        return $this->realises;
    }

    public function addRealise(Realise $realise): self
    {
        if (!$this->realises->contains($realise)) {
            $this->realises[] = $realise;
            $realise->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRealise(Realise $realise): self
    {
        if ($this->realises->removeElement($realise)) {
            // set the owning side to null (unless already changed)
            if ($realise->getUtilisateur() === $this) {
                $realise->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function setAbonnements(?Abonnements $abonnements): self
    {
        $this->abonnements = $abonnements;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
