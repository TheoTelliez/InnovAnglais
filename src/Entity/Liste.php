<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 * @ApiResource()
 */
class Liste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Mot::class, mappedBy="liste")
     */
    private $mots;
    

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="listes")
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="listes")
     */
    private $theme;

    public function __construct()
    {
        $this->mots = new ArrayCollection();
//        $this->entreprises = new ArrayCollection();
//        $this->themes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Mot[]
     */
    public function getMots(): Collection
    {
        return $this->mots;
    }

    public function addMot(Mot $mot): self
    {
        if (!$this->mots->contains($mot)) {
            $this->mots[] = $mot;
            $mot->addListe($this);
        }

        return $this;
    }

    public function removeMot(Mot $mot): self
    {
        if ($this->mots->removeElement($mot)) {
            $mot->removeListe($this);
        }

        return $this;
    }

//    /**
//     * @return Collection|Entreprise[]
//     */
//    public function getEntreprises(): Collection
//    {
//        return $this->entreprises;
//    }
//
//    public function addEntreprise(Entreprise $entreprise): self
//    {
//        if (!$this->entreprises->contains($entreprise)) {
//            $this->entreprises[] = $entreprise;
//            $entreprise->setListe($this);
//        }
//
//        return $this;
//    }
//
//    public function removeEntreprise(Entreprise $entreprise): self
//    {
//        if ($this->entreprises->removeElement($entreprise)) {
//            // set the owning side to null (unless already changed)
//            if ($entreprise->getListe() === $this) {
//                $entreprise->setListe(null);
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return Collection|Theme[]
//     */
//    public function getThemes(): Collection
//    {
//        return $this->themes;
//    }
//
//    public function addTheme(Theme $theme): self
//    {
//        if (!$this->themes->contains($theme)) {
//            $this->themes[] = $theme;
//            $theme->setListe($this);
//        }
//
//        return $this;
//    }
//
//    public function removeTheme(Theme $theme): self
//    {
//        if ($this->themes->removeElement($theme)) {
//            // set the owning side to null (unless already changed)
//            if ($theme->getListe() === $this) {
//                $theme->setListe(null);
//            }
//        }
//
//        return $this;
//    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
