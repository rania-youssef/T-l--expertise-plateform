<?php

namespace App\Entity;

use App\Repository\ExamenATCDRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenATCDRepository::class)
 */
class ExamenATCD
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
    private $Pathologie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Habitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Profession;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $Images = [];

    /**
     * @ORM\OneToOne(targetEntity=Demande::class, inversedBy="examenATCD", cascade={"persist", "remove"})
     */
    private $demande;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathologie(): ?string
    {
        return $this->Pathologie;
    }

    public function setPathologie(string $Pathologie): self
    {
        $this->Pathologie = $Pathologie;

        return $this;
    }

    public function getHabitude(): ?string
    {
        return $this->Habitude;
    }

    public function setHabitude(string $Habitude): self
    {
        $this->Habitude = $Habitude;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->Profession;
    }

    public function setProfession(string $Profession): self
    {
        $this->Profession = $Profession;

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
