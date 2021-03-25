<?php

namespace App\Entity;

use App\Repository\RealiseRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=RealiseRepository::class)
 * @ApiResource()
 */
class Realise
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
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="realises")
     */
    private $test;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="realises")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedujour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDatedujour(): ?\DateTimeInterface
    {
        return $this->datedujour;
    }

    public function setDatedujour(?\DateTimeInterface $datedujour): self
    {
        $this->datedujour = $datedujour;

        return $this;
    }
}
