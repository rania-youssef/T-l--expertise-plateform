<?php

namespace App\Entity;

use App\Repository\DemandeRensRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRensRepository::class)
 */
class DemandeRens
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
    private $Message;

   

    /**
     * @ORM\OneToMany(targetEntity=ReponseRens::class, mappedBy="demandeRens")
     */
    private $reponseRens;

    /**
     * @ORM\ManyToOne(targetEntity=Demande::class, inversedBy="demandeRens")
     */
    private $demande;

    /**
     * @ORM\Column(type="array")
     */
    private $trais = [];

    /**
     * @ORM\Column(type="array")
     */
    private $besoins = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


 

    public function __construct()
    {
        $this->reponseRens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

 
  public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

   

  

    /**
     * @return Collection|ReponseRens[]
     */
    public function getReponseRens(): Collection
    {
        return $this->reponseRens;
    }

    public function addReponseRen(ReponseRens $reponseRen): self
    {
        if (!$this->reponseRens->contains($reponseRen)) {
            $this->reponseRens[] = $reponseRen;
            $reponseRen->setDemandeRens($this);
        }

        return $this;
    }

    public function removeReponseRen(ReponseRens $reponseRen): self
    {
        if ($this->reponseRens->removeElement($reponseRen)) {
            // set the owning side to null (unless already changed)
            if ($reponseRen->getDemandeRens() === $this) {
                $reponseRen->setDemandeRens(null);
            }
        }

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

    public function getTrais(): ?array
    {
        return $this->trais;
    }

    public function setTrais(array $trais): self
    {
        $this->trais = $trais;

        return $this;
    }

    public function getBesoins(): ?array
    {
        return $this->besoins;
    }

    public function setBesoins(array $besoins): self
    {
        $this->besoins = $besoins;

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
