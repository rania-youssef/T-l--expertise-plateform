<?php

namespace App\Entity;

use App\Repository\ExamenCliniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenCliniqueRepository::class)
 */
class ExamenClinique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  
   
    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $images = [];

    /**
     * @ORM\OneToOne(targetEntity=Demande::class, inversedBy="examenClinique", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\Column(type="float")
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EvolutionPoids;

    /**
     * @ORM\Column(type="float")
     */
    private $taille;

    /**
     * @ORM\Column(type="float")
     */
    private $indiceMasse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EtatGenerale;

    

  

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdDemande(): ?Demande
    {
        return $this->idDemande;
    }

    public function setIdDemande(?Demande $idDemande): self
    {
        $this->idDemande = $idDemande;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
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

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getEvolutionPoids(): ?string
    {
        return $this->EvolutionPoids;
    }

    public function setEvolutionPoids(string $EvolutionPoids): self
    {
        $this->EvolutionPoids = $EvolutionPoids;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getIndiceMasse(): ?float
    {
        return $this->indiceMasse;
    }

    public function setIndiceMasse(float $indiceMasse): self
    {
        $this->indiceMasse = $indiceMasse;

        return $this;
    }

    public function getEtatGenerale(): ?string
    {
        return $this->EtatGenerale;
    }

    public function setEtatGenerale(string $EtatGenerale): self
    {
        $this->EtatGenerale = $EtatGenerale;

        return $this;
    }



   
}
