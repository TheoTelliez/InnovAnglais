<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;


    /**
     * @ORM\OneToMany(targetEntity=Realise::class, mappedBy="test")
     */
    private $realises;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="tests")
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;


    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
        $this->realise_test = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->realises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur->removeElement($utilisateur);

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getRealiseTest(): Collection
    {
        return $this->realise_test;
    }

    public function addRealiseTest(Utilisateur $realiseTest): self
    {
        if (!$this->realise_test->contains($realiseTest)) {
            $this->realise_test[] = $realiseTest;
        }

        return $this;
    }

    public function removeRealiseTest(Utilisateur $realiseTest): self
    {
        $this->realise_test->removeElement($realiseTest);

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->setTest($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getTest() === $this) {
                $theme->setTest(null);
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
            $realise->setTest($this);
        }

        return $this;
    }

    public function removeRealise(Realise $realise): self
    {
        if ($this->realises->removeElement($realise)) {
            // set the owning side to null (unless already changed)
            if ($realise->getTest() === $this) {
                $realise->setTest(null);
            }
        }

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
