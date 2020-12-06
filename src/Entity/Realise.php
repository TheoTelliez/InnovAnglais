<?php

namespace App\Entity;

use App\Repository\RealiseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealiseRepository::class)
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
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\Column(type="boolean")
     */
    private $realiseauj;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="realises")
     */
    private $test;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="realises")
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getRealiseauj(): ?bool
    {
        return $this->realiseauj;
    }

    public function setRealiseauj(bool $realiseauj): self
    {
        $this->realiseauj = $realiseauj;

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
}
