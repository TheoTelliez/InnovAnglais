<?php

namespace App\Entity;

use App\Repository\AbonnementsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnementsRepository::class)
 */
class Abonnements
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
     * @ORM\Column(type="boolean")
     */
    private $paiementenunefois;

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

    public function getPaiementenunefois(): ?bool
    {
        return $this->paiementenunefois;
    }

    public function setPaiementenunefois(bool $paiementenunefois): self
    {
        $this->paiementenunefois = $paiementenunefois;

        return $this;
    }
}
