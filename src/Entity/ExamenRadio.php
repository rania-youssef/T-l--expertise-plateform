<?php

namespace App\Entity;

use App\Repository\ExamenRadioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenRadioRepository::class)
 */
class ExamenRadio
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
    private $bassin;

    /**
     * @ORM\Column(type="array")
     */
    private $images = [];

    /**
     * @ORM\OneToOne(targetEntity=Demande::class, inversedBy="examenRadio", cascade={"persist", "remove"})
     */
    private $demande;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBassin(): ?string
    {
        return $this->bassin;
    }

    public function setBassin(string $bassin): self
    {
        $this->bassin = $bassin;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

}
