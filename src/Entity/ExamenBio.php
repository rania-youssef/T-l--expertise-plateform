<?php

namespace App\Entity;

use App\Repository\ExamenBioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenBioRepository::class)
 */
class ExamenBio
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
    private $Hb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VGM;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $Images = [];

    /**
     * @ORM\OneToOne(targetEntity=Demande::class, inversedBy="examenBio", cascade={"persist", "remove"})
     */
    private $demande;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHb(): ?int
    {
        return $this->Hb;
    }

    public function setHb(int $Hb): self
    {
        $this->Hb = $Hb;

        return $this;
    }

    public function getVGM(): ?string
    {
        return $this->VGM;
    }

    public function setVGM(string $VGM): self
    {
        $this->VGM = $VGM;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->Images;
    }

    public function setImages(?array $Images): self
    {
        $this->Images = $Images;

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
