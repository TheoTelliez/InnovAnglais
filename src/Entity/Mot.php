<?php

namespace App\Entity;

use App\Repository\MotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotRepository::class)
 */
class Mot
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
    private $libelle;
    

    /**
     * @ORM\ManyToMany(targetEntity=Liste::class, inversedBy="mots")
     */
    private $liste;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="mots")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleen;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->liste = new ArrayCollection();
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
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setMot($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getMot() === $this) {
                $category->setMot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Liste[]
     */
    public function getListe(): Collection
    {
        return $this->liste;
    }

    public function addListe(Liste $liste): self
    {
        if (!$this->liste->contains($liste)) {
            $this->liste[] = $liste;
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        $this->liste->removeElement($liste);

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLibelleen(): ?string
    {
        return $this->libelleen;
    }

    public function setLibelleen(string $libelleen): self
    {
        $this->libelleen = $libelleen;

        return $this;
    }
}
