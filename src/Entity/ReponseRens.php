<?php

namespace App\Entity;

use App\Repository\ReponseRensRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRensRepository::class)
 */
class ReponseRens
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
    private $Reponse;

    /**
     * @ORM\Column(type="array")
     */
    private $fichiers = [];

    /**
     * @ORM\ManyToOne(targetEntity=DemandeRens::class, inversedBy="reponseRens")
     */
    private $demandeRens;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

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

    public function getFichiers(): ?array
    {
        return $this->fichiers;
    }

    public function setFichiers(array $fichiers): self
    {
        $this->fichiers = $fichiers;

        return $this;
    }

    public function getDemandeRens(): ?DemandeRens
    {
        return $this->demandeRens;
    }

    public function setDemandeRens(?DemandeRens $demandeRens): self
    {
        $this->demandeRens = $demandeRens;

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
}
