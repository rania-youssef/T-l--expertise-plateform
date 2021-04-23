<?php

namespace App\Entity;

use App\Repository\ReponseDRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseDRepository::class)
 */
class ReponseD
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $Reponse;


    /**
     * @ORM\ManyToOne(targetEntity=Demande::class, inversedBy="reponseDs")
     */
    private $demande;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Specialiste::class, inversedBy="reponseDs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Specialiste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->Reponse;
    }

    public function setReponse(string $Reponse): self
    {
        $this->Reponse = $Reponse;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSpecialiste(): ?Specialiste
    {
        return $this->Specialiste;
    }

    public function setSpecialiste(?Specialiste $Specialiste): self
    {
        $this->Specialiste = $Specialiste;

        return $this;
    }

}
